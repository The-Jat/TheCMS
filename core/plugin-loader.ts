import fs from 'fs';
import path from 'path';
import { pathToFileURL } from 'url';
import { RouteRegistry } from './registry/route.registry';
import { PermissionRegistry } from './registry/permission.registry';
import { AdminRegistry } from './registry/admin.registry';

import { HookSystem } from './hooks';
import { Container } from './container';
import { PluginContext } from './plugin-context';

export class PluginLoader {
  private loadedPlugins = new Map<string, any>();

  constructor(
    private container: Container,
  ) { }

  private get routeRegistry() {
    return this.container.get<RouteRegistry>(
      'routeRegistry'
    );
  }

  private get permissionRegistry() {
    return this.container.get<PermissionRegistry>(
      'permissionRegistry'
    );
  }

  private get adminRegistry() {
    return this.container.get<AdminRegistry>(
      'adminRegistry'
    );
  }

  private get hooks() {
    return this.container.get<HookSystem>(
      'hooks'
    );
  }

  private get adminPageRegistry() {
    return this.container.get(
      'adminPageRegistry'
    );
  }

  async discover() {
    const pluginsDir = path.join(process.cwd(), 'plugins');

    if (!fs.existsSync(pluginsDir)) {
      console.log('Plugins directory not found');
      return [];
    }

    const dirs = fs.readdirSync(pluginsDir);

    // PHASE 1: collect manifests
    const manifests: Record<string, any> = {};

    for (const pluginName of dirs) {
      const manifestPath = path.join(
        pluginsDir,
        pluginName,
        'plugin.json',
      );

      if (!fs.existsSync(manifestPath)) continue;

      const manifest = JSON.parse(
        fs.readFileSync(manifestPath, 'utf-8'),
      );

      manifests[manifest.name] = {
        ...manifest,
        pluginName,
      };
    }

    // PHASE 2: sort by dependencies
    const order = this.sortPlugins(manifests);

    // PHASE 3: load plugins in order
    for (const name of order) {
      const manifest = manifests[name];

      if (!manifest) continue;

      await this.hooks.emit('plugin.beforeLoad', manifest);

      if (!manifest.enabled) {
        console.log(`Skipping ${manifest.name}: disabled`);
        continue;
      }

      // load plugin
      const entryPath = path.join(
        pluginsDir,
        manifest.pluginName,
        manifest.entry,
      );

      const pluginModule = await import(
        pathToFileURL(entryPath).href
      );

      const plugin = pluginModule.default;

      // route registration
      this.routeRegistry.register(
        plugin.routes ?? [],
        plugin.name
      );

      this.permissionRegistry.register(
        plugin.permissions ?? [],
        plugin.name
      );

      this.adminRegistry.register(
        plugin.adminNavigation ?? [],
        plugin.name
      );

      this.adminPageRegistry.register(
        plugin.adminPages ?? [],
        plugin.name
      );

      const ctx = new PluginContext(
        { name: plugin.name, version: plugin.version },
        this.hooks,
        this.container,
        {
          route: this.routeRegistry,
          permission: this.permissionRegistry,
          admin: this.adminRegistry,
        }
      );

      this.loadedPlugins.set(plugin.name, {
        plugin,
        ctx,
      });

      console.log("HAS onEnable:", plugin.onEnable);

      // lifecycle 1
      await plugin.onLoad?.(ctx);

      // event after load
      await this.hooks.emit('plugin.loaded', plugin);


      // lifecycle 2 (activation)
      await plugin.onEnable?.(ctx);

      await this.hooks.emit('plugin.afterLoad', plugin);
    }
  }

  private sortPlugins(manifests: Record<string, any>) {
    const sorted: string[] = [];

    const visiting = new Set<string>();
    const visited = new Set<string>();

    const allPlugins = new Set(Object.keys(manifests));

    const visit = (name: string) => {
      const plugin = manifests[name];

      if (!plugin) {
        throw new Error(`Plugin "${name}" not found`);
      }

      // already resolved
      if (visited.has(name)) return;

      // circular dependency detection
      if (visiting.has(name)) {
        throw new Error(
          `Circular dependency detected at plugin "${name}"`
        );
      }

      visiting.add(name);

      const deps = plugin.dependencies || [];

      for (const dep of deps) {
        if (!allPlugins.has(dep)) {
          throw new Error(
            `Missing dependency: "${name}" depends on "${dep}"`
          );
        }

        visit(dep);
      }

      visiting.delete(name);
      visited.add(name);

      sorted.push(name);
    };

    for (const name of Object.keys(manifests)) {
      visit(name);
    }

    return sorted;
  }

  async unloadPlugin(name: string) {
    const entry = this.loadedPlugins.get(name);

    if (!entry) return;

    const { plugin, ctx } = entry;

    // lifecycle hook (optional)
    await plugin.onDisable?.(ctx);

    // remove from memory
    this.loadedPlugins.delete(name);

    this.routeRegistry.unregister(name);

    this.permissionRegistry.unregister(name);

    this.adminRegistry.unregister(name);

    this.adminPageRegistry.unregister(name);

    console.log(`🔴 Plugin unloaded: ${name}`);
  }

  async reloadPlugin(name: string) {
    console.log(`♻️ Reloading plugin: ${name}`);

    const pluginsDir = path.join(process.cwd(), 'plugins');

    const manifestPath = path.join(
      pluginsDir,
      name,
      'plugin.json'
    );

    if (!fs.existsSync(manifestPath)) {
      console.log(`Plugin ${name} not found`);
      return;
    }

    // LOAD MANIFEST
    const manifest = JSON.parse(
      fs.readFileSync(manifestPath, 'utf-8')
    );

    const entryPath = path.join(
      pluginsDir,
      name,
      manifest.entry
    );

    // UNLOAD OLD PLUGIN FIRST
    await this.unloadPlugin(name);

    // EMIT BEFORE LOAD HOOK
    await this.hooks.emit('plugin.beforeLoad', manifest);

    // FRESH IMPORT (ESM-safe cache busting)
    const pluginModule = await import(
      pathToFileURL(entryPath).href + `?t=${Date.now()}`
    );

    const plugin = pluginModule.default;

    // CREATE CONTEXT
    const ctx = new PluginContext(
      { name: plugin.name, version: plugin.version },
      this.hooks,
      this.container,
      {
        route: this.routeRegistry,
        permission: this.permissionRegistry,
        admin: this.adminRegistry,
      }
    );

    // STORE FIRST
    this.loadedPlugins.set(plugin.name, {
      plugin,
      ctx,
    });

    console.log(`🧩 Reloading plugin: ${plugin.name}`);

    // REGISTER SYSTEMS AGAIN
    this.routeRegistry.replace(plugin.routes ?? [], plugin.name);
    this.permissionRegistry.replace(plugin.permissions ?? [], plugin.name);
    this.adminRegistry.replace(plugin.adminNavigation ?? [], plugin.name);

    // Load
    await plugin.onLoad?.(ctx);
    await this.hooks.emit('plugin.loaded', plugin);

    // LIFECYCLE: ENABLE
    await plugin.onEnable?.(ctx);

    // EMIT AFTER LOAD
    await this.hooks.emit('plugin.afterLoad', plugin);

    console.log(`🟢 Plugin reloaded successfully: ${name}`);
  }

  getPlugins() {
    return Array.from(this.loadedPlugins.values());
  }
}