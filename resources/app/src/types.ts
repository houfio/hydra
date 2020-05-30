import { StatusCode } from './constants';

export type Response<T> = {
  success: true,
  data: T
} | {
  success: false,
  error: {
    code: StatusCode,
    message: string,
    info?: unknown
  }
};

export type FormErrors = {
  [key: string]: string[]
};
