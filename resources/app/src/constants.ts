export enum Method {
  Get = 'GET',
  Post = 'POST',
  Put = 'PUT',
  Delete = 'DELETE'
}

export enum StatusCode {
  BadRequest = 400,
  Unauthorized = 401,
  Forbidden = 403,
  NotFound = 404,
  PayloadTooLarge = 413,
  UnsupportedMediaType = 415,
  UnprocessableEntity = 422,
  TooManyRequests = 429,
  InternalServerError = 500
}
