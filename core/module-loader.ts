import fs from 'fs';
import path from 'path';
import { pathToFileURL } from 'url';

import { Container } from './container';
import { ModuleContext } from './module-context';

export class ModuleLoader {

  private modules = new Map();

  constructor(
    private container: Container,
  ) {}

  async load() {

    const modulesDir =
      path.join(process.cwd(), 'modules');

    if (!fs.existsSync(modulesDir)) {
      return;
    }

    const dirs =
      fs.readdirSync(modulesDir);

    for (const dir of dirs) {

      const entry =
        path.join(
          modulesDir,
          dir,
          'index.ts'
        );

      const imported =
        await import(
          pathToFileURL(entry).href
        );

      const module =
        imported.default;

      const ctx =
        new ModuleContext(
          this.container
        );

      await module.register?.(ctx);

      this.modules.set(
        module.name,
        {
          module,
          ctx,
        }
      );
    }

    for (const entry of this.modules.values()) {
      await entry.module.boot?.(
        entry.ctx
      );
    }
  }

  getModules() {
    return Array.from(
      this.modules.values()
    );
  }
}