export function definePlugin(plugin) {
    if (typeof window !== 'undefined') {
        Object.entries(plugin.components || {}).forEach(([name, component]) => {
            window.TheCMS
                .PluginAPI
                .registerComponent(name, component);
        });
    }
    return plugin;
}
