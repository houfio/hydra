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
      </div>
      <div class="box">
        <div v-for="offerDish of offer.dishes" class="dish">
          <div>
            {{ offerDish.name }}
          </div>
          <div>
            <Button @click.native="remove(offerDish)">
              Verwijderen
            </Button>
          </div>
        </div>
      </div>
      <div class="box">
        <div class="spacing">
          <div class="info">
            <span class="big">
              0
            </span>
            totaal incl. btw
          </div>
          <div class="info">
            <Button>
              Aanmaken
            </Button>
            <Button @click.native="cancel">
              Annuleren
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
  import Input from '../../components/form/Input.vue';
  import { Method } from '../../constants';
  import { Dish, DishesApi, DishType, Offer, OfferDish, OffersApi, OrderDish } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      Button
    }
  })
  export default class CreateOffer extends Vue {
    public types: DishType[] = [];
    public offer: Partial<Offer> = {
      name: '',
      price: 0,
      valid_until: '',
      dishes: []
    };

    public async mounted() {
      const response = await request<DishesApi>('/dishes', Method.Get);

      if (response.success) {
        this.types = response.data.types;
      }
    }

    public add(dish: Dish) {
      const foundDish = this.offer.dishes!.find((offerDish) => offerDish.id === dish.id);

      if (!foundDish) {
        (this.offer.dishes! as OfferDish[]).push({
          id: dish.id,
          name: dish.name
        });
      }
    }

    public remove(dish: Dish | OfferDish) {
      const foundDish = this.offer.dishes!.find((orderDish) => orderDish.id === dish.id);

      if (foundDish) {
        this.offer.dishes = this.offer.dishes!.filter((orderDish) => orderDish.id !== dish.id);
      }
    }

    public cancel() {
      this.offer = {
        name: '',
        price: 0,
        valid_until: '',
        dishes: []
      };
    }
  }
</script>

<style scoped lang="scss">
  .note {
    background-color: white;
    color: black;
  }

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
