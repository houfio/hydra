<template>
  <Page>
    <div class="grid">
      <div class="box big">
        <Loader v-if="loading"/>
        <div v-else v-for="order of orders.orders" class="order">
          <div>
            {{ format(order.created_at) }}
          </div>
          <div>
            {{ order.dishes.length + order.offers.length }} gerechten besteld
          </div>
          <div>
            &euro;{{ (calculatePrice(order.dishes) + calculatePrice(order.offers)).toFixed(2) }}
          </div>
          <div>
            <Button @click.native="selected = order">
              Bekijken
            </Button>
          </div>
        </div>
      </div>
      <div class="box">
        <div v-if="Object.keys(selected).length" >
          <div v-for="dish of selected.dishes" class="order">
            <div>
              x{{ dish.pivot.quantity }}
            </div>
            <div>
              {{ dish.name }}
            </div>
            <div>
              &euro;{{ (dish.pivot.quantity * dish.pivot.price).toFixed(2) }}
            </div>
            <div></div>
          </div>
          <div v-for="dish of selected.offers" class="order">
            <div>
              x{{ dish.pivot.quantity }}
            </div>
            <div>
              {{ dish.name }}
            </div>
            <div>
              &euro;{{ (dish.pivot.quantity * dish.pivot.price).toFixed(2) }}
            </div>
            <div></div>
          </div>
        </div>
        <p v-else>Selecteer een bestelling</p>
      </div>
      <div class="box">
        <div v-if="Object.keys(selected).length" class="spacing">
          <div class="info">
            <span class="big">
              &euro;{{ calculatePrice(selected.dishes).toFixed(2) }}
            </span>
            totaal incl. btw
          </div>
          <div class="info">
            <span class="big">
              {{ format(selected.created_at) }}
            </span>
            geplaatst op
          </div>
        </div>
        <p v-else>Selecteer een bestelling</p>
      </div>
    </div>
  </Page>
</template>

<script lang="ts">
  import { format, parseISO } from 'date-fns';
  import { nl } from 'date-fns/locale';
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Page from '../../components/admin/Page.vue';
  import Button from '../../components/form/Button.vue';
  import Form from '../../components/form/Form.vue';
  import Loader from '../../components/Loader.vue';
  import { Method } from '../../constants';
  import { Dish, Offer, Order, OrdersApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      Button,
      Form,
      Loader
    }
  })
  export default class Orders extends Vue {
    public orders: Partial<OrdersApi> = {};
    public selected: Partial<Order> = {};

    public format(date: string) {
      return format(parseISO(date), 'PPpp', { locale: nl });
    }

    public get loading() {
      return !Object.keys(this.orders).length;
    }

    public calculatePrice(dishes: any): number {
      return dishes.reduce((prev: any, curr: any) => prev + (curr.pivot!.price * curr.pivot!.quantity), 0);
    }

    public async mounted() {
      const response = await request<OrdersApi>('/orders', Method.Get);

      if (response.success) {
        this.orders = response.data;
      }
    }
  }
</script>

<style scoped lang="scss">
  .grid {
    display: grid;
    grid-template: calc(100vh - 19rem) 12rem / 3fr 2fr;
    grid-gap: 1rem;
  }

  .spacing {
    display: flex;
    justify-content: space-around;
    align-items: center;
    height: 100%;
  }

  .info {
    display: flex;
    flex-direction: column;
    align-items: center;

    & .big {
      margin-bottom: .5rem;
      font-size: 2rem;
      font-weight: bold;
    }
  }

  .box {
    padding: 1rem;
    background-color: #262626;
    border-radius: 1rem;

    &.big {
      grid-row: span 2;
      overflow-y: scroll;
    }
  }

  .order {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;

    & > div:nth-child(1) {
      margin-right: 1rem;
    }

    & > div:nth-child(2) {
      flex: 2;
    }

    & > div:nth-child(3) {
      margin-right: 1rem;
    }

    &:last-child {
      margin-bottom: 2rem;
    }
  }
</style>
