<template>
  <Page>
    <div class="orders">
      <div v-for="order of orders.orders">
        {{ format(order.created_at) }} geleden | Aantal gerechten: {{ calculateDishes(order.dishes) + calculateDishes(order.offers) }}
        <UglyButton @click.native="submit(order)">
          Herhaal bestelling
        </UglyButton>
      </div>
    </div>
  </Page>
</template>

<script lang="ts">
  import { formatDistance, parseISO } from 'date-fns';
  import { nl } from 'date-fns/locale';
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Mutation } from 'vuex-class';

  import Form from '../../components/form/Form.vue';
  import UglyButton from '../../components/form/UglyButton.vue';
  import Page from '../../components/Page.vue';
  import { Method } from '../../constants';
  import { Dish, Order, OrderApi, OrdersApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      UglyButton,
      Form
    }
  })
  export default class History extends Vue {
    public orders: Partial<OrdersApi> = {};
    public loading = false;

    @Mutation('clear', { namespace: 'cart' })
    private clear!: () => void;

    @Mutation('push', { namespace: 'notification' })
    private push!: (notification: string) => void;

    public async mounted() {
      await this.getOrders();
    }

    public format(date: string) {
      return formatDistance(parseISO(date), new Date(), {locale: nl});
    }

    public calculateDishes(dishes: any): number {
      return dishes.reduce((prev: any, curr: any) => prev + curr.pivot!.quantity, 0);
    }

    public async submit(order: Order) {
      const dishes: any[] = [];
      const offers: any[] = [];

      order.dishes.map((d) => {
        dishes.push({
          ...d,
          quantity: d.pivot!.quantity,
          note: d.pivot!.note
        });
      });

      order.offers!.map((o) => {
        offers.push({
          ...o,
          quantity: o.pivot!.quantity,
          note: o.pivot!.note
        });
      });

      const response = await request<OrderApi>('/orders', Method.Post, {
        dishes,
        offers
      });

      if (response.success) {
        this.clear();
        await this.getOrders();
      } else if (response.error.message === 'Order cannot be placed yet.') {
        window.alert('Er moeten 10 minuten tussen twee bestellingen zitten');
      }
    }

    private async getOrders() {
      const response = await request<OrdersApi>('/orders', Method.Get);

      if (response.success) {
        this.orders = response.data;
      }
    }
  }
</script>

<style scoped lang="scss">
  .orders {
    display: flex;
    flex-direction: column;
  }
</style>
