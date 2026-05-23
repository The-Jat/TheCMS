import { match } from 'path-to-regexp';

export interface CompiledRoute {
  matcher: ReturnType<typeof match>;
}

export function compileRoute(path: string) {
  return match(path, {
    decode: decodeURIComponent,
  });
}