type EventCallback = (payload: any) => void | Promise<void>;

export class HookSystem {
  private listeners: Record<string, EventCallback[]> = {};

  // register listener
  on(event: string, callback: EventCallback) {
    if (!this.listeners[event]) {
      this.listeners[event] = [];
    }

    this.listeners[event].push(callback);
  }

  // emit event
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

    namespace(plugin: string) {
        return {
            on: (event: string, cb: EventCallback) => {
                return this.on(`${plugin}:${event}`, cb);
            },

            emit: async (event: string, payload?: any) => {
                return this.emit(`${plugin}:${event}`, payload);
            },
        };
    }
}