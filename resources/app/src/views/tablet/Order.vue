<template>
  <Page>
    <div class="dishes">
      <div v-for="dish of dishes">
        {{ dish.quantity }}x {{ getName(dish.id, dish.isOffer) }}
        <button
            @click="removeDish({id: dish.id, isOffer: dish.isOffer})"
        >
          <FontAwesomeIcon :icon="minus"/>
        </button>
        <button
            @click="addDish({id: dish.id, isOffer: dish.isOffer})"
        >
          <FontAwesomeIcon :icon="plus"/>
        </button>
      </div>
    </div>
    <Form @submit="submit" v-slot="{ loading }">
      <UglyButton :disabled="loading || !dishes.length">
        Plaats bestelling
      </UglyButton>
    </Form>
  </Page>
</template>

<script lang="ts">
  import { faMinus, faPlus } from '@fortawesome/free-solid-svg-icons';
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Mutation, State } from 'vuex-class';

  import Form from '../../components/form/Form.vue';
  import UglyButton from '../../components/form/UglyButton.vue';
  import Page from '../../components/Page.vue';
  import { Method } from '../../constants';
  import { MenuApi, OrderApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Form,
      UglyButton,
      Page,
      FontAwesomeIcon
    }
  })
  export default class Order extends Vue {
    public response: Partial<MenuApi> = {};

    @State('dishes', { namespace: 'cart' })
    public dishes!: { id: number, quantity: number, isOffer: boolean }[];

    @Mutation('clear', { namespace: 'cart' })
    private clear!: () => void;

    @Mutation('addDish', { namespace: 'cart' })
    private addDish!: (params: {id: number, isOffer: boolean}) => void;

    @Mutation('removeDish', { namespace: 'cart' })
    private removeDish!: (params: {id: number, isOffer: boolean}) => void;

    public get plus() {
      return faPlus;
    }

    public get minus() {
      return faMinus;
    }

    public async mounted() {
      const response = await request<MenuApi>('/menu', Method.Get);

      if (response.success) {
        this.response = response.data;
      }
    }

    public async submit(api: typeof request) {
      const response = await api<OrderApi>('/orders', Method.Post, {
        dishes: this.dishes!.filter((d) => !d.isOffer),
        offers: this.dishes!.filter((d) => d.isOffer)
      });

      if (response.success) {
        this.clear();
      }
    }

    public getName(id: number, isOffer: boolean) {
      if (!this.response.types || (!this.response.offers && isOffer)) {
        return;
      }

      return isOffer ?
        this.response.offers!.find((o) => o!.id === id)?.name :
        this.response.types.flatMap((t) => t.dishes).find((d) => d!.id === id)?.name;
    }
  }
</script>

<style scoped lang="scss">
  .dishes {
    display: flex;
    flex-direction: column;
  }
</style>
