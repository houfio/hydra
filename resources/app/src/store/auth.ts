import { Module, Mutation, VuexModule } from 'vuex-module-decorators';

@Module({
  namespaced: true
})
export default class extends VuexModule {
  token?: string;

  @Mutation
  public setToken(token?: string) {
    this.token = token;
  }
}
