import store from '../store';

export async function request(url: string, payload: object) {
  console.log(store.state.auth.token);

  try {
    const result = await fetch(`${process.env.VUE_APP_API}${url}`, {
      body: JSON.stringify(payload)
    });
  } catch (e) {
    console.error('oops', e);
  }

  return {
    data: ''
  };
}
