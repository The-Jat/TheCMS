type EventCallback = (payload: any) => void | Promise<void>;

export class HookSystem {
  private listeners: Record<string, EventCallback[]> = {};

  on(event: string, callback: EventCallback) {
    if (!this.listeners[event]) {
      this.listeners[event] = [];
    }

    this.listeners[event].push(callback);
  }

  async emit(event: string, payload?: any) {
    const handlers = this.listeners[event] || [];

    for (const handler of handlers) {
      await handler(payload);
    }
  }

  off(event: string, callback: EventCallback) {
    const handlers = this.listeners[event];
    if (!handlers) return;

    this.listeners[event] = handlers.filter(h => h !== callback);
  }

  // plugin scoped wrapper
  forPlugin(pluginName: string) {
    return {
      on: (event: string, cb: EventCallback) => {
        this.on(`${pluginName}:${event}`, cb);
      },

      emit: async (event: string, payload?: any) => {
        await this.emit(`${pluginName}:${event}`, payload);
      },
    };
  }
}