import { StatusCode } from './constants';

export type FunctionArguments<T> = T extends (...args: infer V) => any ? V : never;

export type Notification = {
  id: string,
  notification: string
};

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
  types: Type[]
};

export type OrderApi = {
  order: number
};

export type DishApi = {
  dish: Dish
};

export type TypeApi = {
  type: Type
};

export type OfferApi = {
  offer: Offer
};

export type OffersApi = {
  offers: Offer[]
};

export type OrdersApi = {
  orders: Order[]
};

export type Order = {
  id: number,
  session_id?: number,
  created_at: string,
  dishes: Dish[]
};

export type MenuApi = {
  types: Type[],
  offers: Offer[]
};

export type MenuDownloadApi = {
  url: string
};

export type Offer = {
  id?: number,
  name: string,
  tax?: number,
  price: number,
  valid_until: string | null,
  dishes: Dish[] | OfferDish[]
};

export type Type = {
  id?: number,
  name: string,
  dishes?: Dish[]
};

export type Dish = {
  id?: number,
  number: string,
  price: number,
  description: string | null,
  name: string,
  type_id?: number
  pivot?: OrderDishPivot
};

export type OrderDishPivot = {
  order_id: number,
  dish_id: number,
  price: number,
  quantity: number,
  tax: number,
  note: string | null
};

export type OrderDish = {
  id?: number,
  price: number,
  name: string,
  quantity: number,
  isOffer: boolean,
  note?: string
};

export type OfferDish = {
  id?: number,
  name: string
};
