import { Module, Mutation, VuexModule } from 'vuex-module-decorators';

@Module({
  namespaced: true
})
export default class extends VuexModule {
  public dishes: { id: number, quantity: number }[] = [];

  @Mutation
  public addDish(id: number) {
    const has = this.dishes.some((dish) => dish.id === id);

    this.dishes = [
      ...this.dishes.map((dish) => dish.id !== id ? dish : {
        ...dish,
        quantity: dish.quantity + 1
      }),
      ...has ? [] : [{
        id,
        quantity: 1
      }]
    ];
  }

  @Mutation
  public removeDish(id: number) {
    this.dishes = this.dishes.map((dish) => dish.id !== id ? dish : {
      ...dish,
      quantity: dish.quantity - 1
    }).filter((dish) => dish.quantity > 0);
  }

  @Mutation
  public clear() {
    this.dishes = [];
  }
}
