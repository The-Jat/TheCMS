import { PluginLoader } from './plugin-loader';

function bootstrap() {
  const loader = new PluginLoader();

  loader.discover();
}

bootstrap();