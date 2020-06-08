<template>
  <Page>
    <div class="grid">
      <div class="box big">
        <div v-for="type of types">
          <span class="type">
            {{ type.name }}
          </span>
          <div v-for="dish of type.dishes" class="dish">
            <div>
              {{ dish.number }}
            </div>
            <div>
              {{ dish.name }}
            </div>
            <div>
              &euro;{{ dish.price.toFixed(2) }}
            </div>
            <div>
              <Button @click.native="add(dish)">
                Toevoegen
              </Button>
            </div>
          </div>
        </div>
        <span class="offer-heading">
          Aanbiedingen
        </span>
        <div v-for="offer of offers">
          <div class="dish">
            <div style="width: 0"></div>
            <div class="offer">
              {{ offer.name }}
            </div>
            <div>
              &euro;{{ offer.price.toFixed(2) }}
            </div>
            <div>
              <Button @click.native="add(offer)">
                Toevoegen
              </Button>
            </div>
          </div>
          <div v-for="dish of offer.dishes" class="dish">
            <div></div>
            <div>
              {{ dish.name }}
            </div>
            <div></div>
            <div></div>
          </div>
        </div>
      </div>
      <div class="box">
        <div v-for="dish of order" class="dish">
          <div>
            x{{ dish.quantity }}
          </div>
          <div>
            {{ dish.name }}
          </div>
          <div>
            &euro;{{ dish.price.toFixed(2) }}
          </div>
          <div class="row">
            <Button @click.native="remove(dish)">
              -
            </Button>
            <Button @click.native="add(dish)">
              +
            </Button>
          </div>
        </div>
      </div>
      <div class="box">
        <div class="spacing">
          <div class="info">
            <span class="big">
              &euro;{{ totalAmount }}
            </span>
            totaal incl. btw
          </div>
          <div class="info">
            <Button :disabled="!order.length" @click.native="pay">
              Afrekenen
            </Button>
            <Button @click.native="deleteOrder">
              Verwijderen
            </Button>
          </div>
        </div>
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
  import { Dish, DishesApi, DishType, Offer, OffersApi, OrderDish } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      Button,
      Form
    }
  })
  export default class Dashboard extends Vue {
    public types: DishType[] = [];
    public offers: Offer[] = [];
    public order: OrderDish[] = [];

    get totalAmount() {
      return this.order.reduce((a, b) => a + b.price * b.quantity, 0).toFixed(2);
    }

    public async mounted() {
      const response = await request<DishesApi>('/dishes', Method.Get);
      const offers = await request<OffersApi>('/offers', Method.Get);

      if (response.success) {
        this.types = response.data.types;
      }

      if (offers.success) {
        this.offers = offers.data.offers;
      }
    }

    public add(dish: Dish | Offer) {
      const foundDish = this.order.find((orderDish) => orderDish.id === dish.id);

      if (!foundDish) {
        this.order.push({
          id: dish.id,
          name: dish.name,
          price: dish.price,
          quantity: 1,
          isOffer: dish.hasOwnProperty('dishes')
        });
      } else {
        ++foundDish.quantity;
      }
    }

    public remove(dish: OrderDish) {
      const foundDish = this.order.find((orderDish) => orderDish.id === dish.id);

      if (!foundDish) {
        return;
      }

      if (foundDish.quantity === 1) {
        this.order = this.order.filter((orderDish) => orderDish.id !== dish.id);
      } else {
        --foundDish.quantity;
      }
    }

    public deleteOrder() {
      this.order = [];
    }

    public async pay() {
      const response = await request<DishesApi>('/orders', Method.Post, {
        dishes: this.order.filter((line) => !line.isOffer),
        offers: this.order.filter((line) => line.isOffer)
      });

      if (response.success) {
        this.order = [];
        window.alert('Bestelling aangemaakt');
      } else {
        window.alert('Bestelling niet aangemaakt');
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
