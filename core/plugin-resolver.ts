import { PluginLoader } from "./plugin-loader";
import { CompiledRoute } from "./router/route-matcher";

export class PluginResolver {

  constructor(
    private pluginLoader: PluginLoader,
  ) {}

  resolve(route: CompiledRoute) {

    return this.pluginLoader
      .getPlugins()
      .find(
        (p: any) =>
          p.plugin.name === route.pluginName
      )?.plugin;
  }
}