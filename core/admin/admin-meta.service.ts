export class AdminMetaService {

  constructor(
    private navigation,
    private pages,
  ) {}

  getMeta() {
    return {
      theme: 'default',

      navigation:
        this.navigation.getAll(),

      pages:
        this.pages.getAll(),
    };
  }
}