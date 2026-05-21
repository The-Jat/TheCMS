import fs from 'fs';
import path from 'path';

export class PluginLoader {
  async discover() {
    const pluginsDir = path.join(process.cwd(), 'plugins');

    const plugins = fs.readdirSync(pluginsDir);

    for (const pluginName of plugins) {
      const manifestPath = path.join(
        pluginsDir,
        pluginName,
        'plugin.json',
      );

      const manifest = JSON.parse(
        fs.readFileSync(manifestPath, 'utf-8'),
      );

      if (!manifest.enabled) continue;

      console.log(`Loading plugin: ${manifest.name}`);
    }
  }
}