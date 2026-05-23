type EventCallback<T = any> = (payload: T) => void | Promise<void>;

export class HookSystem {
  private listeners: Record<string, EventCallback[]> = {};

  on<T = any>(event: string, callback: EventCallback<T>) {
    if (!this.listeners[event]) {
      this.listeners[event] = [];
    }

    this.listeners[event].push(callback);
  }

  async emit<T = any>(event: string, payload?: T) {
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

  clear(event?: string) {
    if (event) {
      delete this.listeners[event];
    } else {
      this.listeners = {};
    }
  }

  list() {
    return Object.keys(this.listeners);
  }
}