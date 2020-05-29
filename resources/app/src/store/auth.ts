import { Action, Module, Mutation, VuexModule } from 'vuex-module-decorators';

import { request } from '../utils/request';

@Module({
  namespaced: true
})
export default class extends VuexModule {
  #token = '';

  get token() {
    return this.#token;
  }

  @Mutation
  public setToken(token: string) {
    this.#token = token;
  }

  @Action({ commit: 'setToken' })
  public async authenticate(id: number, password: string) {
    const { data } = await request('/api/login', {
      id,
      password
    });

    return data;
  }
}
