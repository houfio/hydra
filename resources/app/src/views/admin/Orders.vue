<template>
  <Page>
    <div class="grid">
      <div class="box big">
        <div v-for="order of orders" class="order">
          <div>
            {{ order.created_at }}
          </div>
          <div>
            {{ order.dishes.length }} gerechten besteld
          </div>
          <div>
            &euro;{{ calculatePrice(order.dishes) }}
          </div>
          <div>
            <Button @click.native="selected = order">
              Bekijken
            </Button>
          </div>
        </div>
      </div>
      <div class="box">
        <div v-if="Object.keys(selected).length" v-for="dish of selected.dishes" class="dish">
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
        <p v-else>Selecteer een bestelling</p>
      </div>
      <div class="box">
        <div v-if="Object.keys(selected).length" class="spacing">
          <div class="info">
            <span class="big">
              &euro;{{ calculatePrice(selected.dishes) }}
            </span>
            totaal incl. btw
          </div>
          <div class="info">
            <span class="big">
              {{ selected.created_at }}
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
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Page from '../../components/admin/Page.vue';
  import Button from '../../components/form/Button.vue';
  import Form from '../../components/form/Form.vue';
  import { Method } from '../../constants';
  import { Dish, Order, OrdersApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      Button,
      Form
    }
  })
  export default class Orders extends Vue {
    public orders: Order[] = [];
    public selected: Partial<Order> = {};

    public calculatePrice(dishes: Dish[]): string {
      return dishes.reduce((prev, curr) => prev + (curr.pivot!.price * curr.pivot!.quantity), 0).toFixed(2);
    }

    public async mounted() {
      const response = await request<OrdersApi>('/orders', Method.Get);

      if (response.success) {
        this.orders = response.data.orders;
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

  .row {
    display: flex;

    button:first-child {
      border-top-right-radius: 0;
      border-bottom-right-radius: 0;
    }

    button:last-child {
      border-top-left-radius: 0;
      border-bottom-left-radius: 0;
    }
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

  .offer-heading {
    display: flex;
    justify-content: center;
    margin-bottom: 1rem;
    font-size: 2rem;
  }

  .offer {
    display: flex;
    justify-content: flex-start;
    margin-bottom: 1rem;
    font-size: 1.25rem;
  }

  .type {
    display: flex;
    justify-content: center;
    margin-bottom: 1rem;
    font-size: 1.75rem;
  }

  .order {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;

    & > div:nth-child(1) {
      width: 25rem;
    }

    & > div:nth-child(2) {
      flex: 1;
    }

    & > div:nth-child(3) {
      margin-right: 1rem;
    }

    &:last-child {
      margin-bottom: 2rem;
    }
  }

  .dish {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;

    & > div:nth-child(1) {
      width: 5rem;
    }

    & > div:nth-child(2) {
      flex: 1;
    }

    & > div:nth-child(3) {
      margin-right: 1rem;
    }

    &:last-child {
      margin-bottom: 2rem;
    }
  }
</style>
