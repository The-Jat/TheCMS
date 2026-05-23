import { HttpException } from './http.exception';

export class NotFoundException
  extends HttpException {

  constructor(
    message = 'Resource not found'
  ) {
    super(404, message);
  }
}