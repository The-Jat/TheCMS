export function scoreRoute(path: string): number {

  return path
    .split('/')
    .filter(Boolean)
    .reduce((score, segment) => {

      // dynamic param
      if (segment.startsWith(':')) {
        return score + 1;
      }

      // static segment
      return score + 10;

    }, 0);
}