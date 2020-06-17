import { Module, Mutation, VuexModule } from 'vuex-module-decorators';

@Module({
  namespaced: true
})
export default class extends VuexModule {
  public dishes: { id: number, quantity: number, isOffer: boolean }[] = [];

  @Mutation
  public addDish(params: {id: number, isOffer: boolean}) {
    const has = this.dishes.some((dish) => dish.id === params.id && dish.isOffer === params.isOffer);

    this.dishes = [
      ...this.dishes.map((dish) => dish.id !== params.id || dish.isOffer !== params.isOffer ? dish : {
        ...dish,
        quantity: dish.quantity + 1
      }),
      ...has ? [] : [{
        id: params.id,
        isOffer: params.isOffer,
        quantity: 1
      }]
    ];
  }

  @Mutation
  public removeDish(params: {id: number, isOffer: boolean}) {
    this.dishes = this.dishes.map((dish) => dish.id !== params.id || dish.isOffer !== params.isOffer ? dish : {
      ...dish,
      quantity: dish.quantity - 1
    }).filter((dish) => dish.quantity > 0);
  }

  @Mutation
  public clear() {
    this.dishes = [];
  }
}
