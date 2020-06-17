import store from '../store';

export function authenticated() {
  return Boolean(store.state.auth.token);
}
