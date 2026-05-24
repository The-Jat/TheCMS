import { Container } from './container';

export class ModuleContext {
    public readonly services: {
        logger: any;
        config: any;
    };

    constructor(
        public readonly container: Container,
    ) {
        this.services = {
            logger: container.get('logger'),
            config: container.get('config'),
        };
    }
}