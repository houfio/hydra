import { StatusCode } from './constants';

export type FunctionArguments<T> = T extends (...args: infer V) => any ? V : never;

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
    },
    order: {
      id: number,
      created_at: string
    }
  }>,
  revenue: number,
  vat: number
};

export type DishesApi = {
  types: DishType[]
};

export type OffersApi = {
  offers: Offer[]
};

export type MenuApi = {
  url: string
};

export type Offer = {
  id: number,
  name: string,
  tax: number,
  price: number,
  dishes: Dish[] | OfferDish[]
};

export type DishType = {
  id: number,
  name: string,
  dishes: Dish[]
};

export type Dish = {
  id: number,
  number: string,
  price: number,
  description: string | null,
  name: string
};

export type OrderDish = {
  id: number,
  price: number,
  name: string,
  quantity: number,
  isOffer: boolean
};

export type NewDish = {
  number: string,
  price: number,
  description: string,
  name: string,
  type_id: number
};

export type OfferDish = {
  id: number,
  name: string
};

export type SelectType = {
  id: number,
  label: string
};
