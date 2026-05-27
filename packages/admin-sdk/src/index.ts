export interface AdminPluginDefinition {
  components?: Record<string, any>;
}

export function definePlugin(
  plugin: AdminPluginDefinition
) {

  if (
    typeof window !== 'undefined'
  ) {

    Object.entries(
      plugin.components || {}
    ).forEach(
      ([name, component]) => {

        window.TheCMS
          .PluginAPI
          .registerComponent(
            name,
            component
          );
      }
    );
  }

  return plugin;
}