export class HttpException extends Error {

  constructor(
    public status: number,
    message: string,
    public details?: any,
  ) {
    super(message);

    this.name = this.constructor.name;
  }
}