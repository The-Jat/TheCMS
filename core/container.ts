export class Container {
  private services = new Map<string, any>();

  register(name: string, instance: any) {
    if (this.services.has(name)) {
      throw new Error(`Service "${name}" already registered`);
    }

    this.services.set(name, instance);
  }

  get<T = any>(name: string): T {
    const service = this.services.get(name);

    if (!service) {
      throw new Error(`Service "${name}" not found`);
    }

    return service;
  }
}