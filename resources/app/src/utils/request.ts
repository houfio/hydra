import { stringify } from 'query-string';

import { Method } from '../constants';
import router from '../router';
import store from '../store';
import { Response } from '../types';

export function request<T>(url: string, method: Method.Get, payload?: object): Promise<Response<T>>;
export function request(url: string, method: Method.Delete): Promise<boolean>;
export function request<T>(url: string, method: Method, payload: object): Promise<Response<T>>;

export async function request<T>(url: string, method: Method, payload?: object) {
  const token = store.state.auth.token;
  const query = method === Method.Get && payload ? `?${stringify(payload)}` : '';

  try {
    const response = await fetch(`${process.env.VUE_APP_API}${url}${query}`, {
      method,
      body: method !== Method.Get ? JSON.stringify(payload) : undefined,
      headers: {
        'content-type': 'application/json',
        ...token && {
          authorization: `Bearer ${store.state.auth.token}`
        }
      }
    });

    if (response.status === 401) {
      store.commit('auth/setToken');

      await router.push('/');
    }

    return method === Method.Delete ? true : await response.json();
  } catch (e) {
    return method === Method.Delete ? false : {
      success: false,
      error: {
        code: 500,
        message: e.message
      }
    };
  }
}
