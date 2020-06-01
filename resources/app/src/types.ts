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

export type Paginated<T> = {
  data: T[],
  current_page: number,
  last_page: number,
  per_page: number,
  total: number,
  from: number | null,
  to: number | null,
  path: string,
  first_page_url: string,
  last_page_url: string,
  next_page_url: string | null,
  prev_page_url: string | null
};

export type LoginApi = {
  token: string
};

export type ReportApi = {
  dishes: Paginated<{
    id: number,
    dish_id: number,
    order_id: number,
    price: number,
    quantity: number,
    tax: number,
    note: string | null,
    dish: {
      id: number,
      name: string
    }
  }>,
  revenue: number,
  vat: number
};
