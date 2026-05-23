type HookCallback<T = any> = (payload: T) => void | Promise<void>;

export class HookSystem {
  private listeners: Record<string, HookCallback[]> = {};

  on<T = any>(event: string, callback: HookCallback<T>) {
    if (!this.listeners[event]) {
      this.listeners[event] = [];
    }

    this.listeners[event].push(callback);
  }

  async emit<T = any>(event: string, payload: T) {
    const callbacks = this.listeners[event] || [];

    for (const cb of callbacks) {
      await cb(payload);
    }
  }

  clear(event?: string) {
    if (event) {
      delete this.listeners[event];
    } else {
      this.listeners = {};
    }
  }
}