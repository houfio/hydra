import { Method } from '../constants';
import store from '../store';
import { Response } from '../types';

export function request<T>(url: string, method: Method.Get): Promise<Response<T>>;
export function request(url: string, method: Method.Delete): Promise<boolean>;
export function request<T>(url: string, method: Method, payload: object): Promise<Response<T>>;

export async function request<T>(url: string, method: Method, payload?: object) {
  const token = store.state.auth.token;

  try {
    const response = await fetch(`${process.env.VUE_APP_API}${url}`, {
      method,
      body: JSON.stringify(payload),
      headers: {
        'content-type': 'application/json',
        ...token && {
          authorization: `Bearer ${store.state.auth.token}`
        }
      }
    });

    return method === Method.Delete ? true : await response.json();
  } catch (e) {
    return method === Method.Delete ? false : {
      success: false,
      error: {
        code: 500,
        message: 'Unknown error'
      }
    };
  }
}
