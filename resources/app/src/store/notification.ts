import shortid from 'shortid';
import { Module, Mutation, VuexModule } from 'vuex-module-decorators';

import { Notification } from '../types';

@Module({
  namespaced: true
})
export default class extends VuexModule {
  public notifications: Notification[] = [];

  @Mutation
  public push(notification: string) {
    this.notifications = [
      ...this.notifications,
      { id: shortid(), notification }
    ];
  }

  @Mutation
  public remove(id: string) {
    this.notifications = this.notifications.filter((n) => n.id !== id);
  }
}
