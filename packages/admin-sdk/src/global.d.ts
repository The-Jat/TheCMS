declare global {

  interface Window {

    TheCMS: {
      PluginAPI: {
        registerComponent(
          name: string,
          component: any
        ): void;
      };
    };
  }
}

export {};