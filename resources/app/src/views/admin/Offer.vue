<template>
  <Page>
    <div class="grid">
      <div class="box big">
        <Loader v-if="loading"/>
        <div v-else v-for="type of response.types">
          <span class="heading">
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
          <div style="width: 0"/>
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
        <Form @submit="submit" v-slot="{ loading, errors }">
          <Input label="Naam" type="text" v-model="offer.name" :errors="errors['name']"/>
          <Input label="Prijs" type="number" step="0.01" v-model.number="offer.price" :errors="errors['price']"/>
          <Input label="Geldig tot" type="datetime-local" v-model="offer.valid_until" :errors="errors['valid_until']"/>
          <Button :disabled="loading || !offer.dishes.length">
            {{ editing ? 'Bewerken' : 'Aanmaken' }}
          </Button>
        </Form>
      </div>
    </div>
  </Page>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Mutation } from 'vuex-class';

  import Page from '../../components/admin/Page.vue';
  import Button from '../../components/form/Button.vue';
  import Form from '../../components/form/Form.vue';
  import Input from '../../components/form/Input.vue';
  import Loader from '../../components/Loader.vue';
  import { Method } from '../../constants';
  import { Dish, DishesApi, Offer as OfferType, OfferApi, OfferDish } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Form,
      Page,
      Button,
      Input,
      Loader
    }
  })
  export default class Offer extends Vue {
    public response: Partial<DishesApi> = {};
    public offer: OfferType = {
      name: '',
      price: 0,
      valid_until: '',
      dishes: []
    };

    @Mutation('push', {namespace: 'notification'})
    private push!: (notification: string) => void;

    public get loading() {
      return !Object.keys(this.response).length;
    }

    public get id() {
      return parseInt(this.$route.params.id, 10);
    }

    public get editing() {
      return !isNaN(this.id);
    }

    public async mounted() {
      const [types, offer] = await Promise.all([
        request<DishesApi>('/dishes', Method.Get),
        this.editing ? request<OfferApi>(`/offers/${this.id}`, Method.Get) : undefined
      ]);

      if (types.success) {
        this.response = types.data;
      }

      if (offer?.success) {
        this.offer = {
          ...offer.data.offer,
          valid_until: offer.data.offer.valid_until.replace(' ', 'T')
        };
      }
    }

    public async submit(api: typeof request) {
      const response = this.editing
        ? await api<DishesApi>(`/offers/${this.offer.id}`, Method.Put, this.offer)
        : await api<DishesApi>('/offers', Method.Post, this.offer);

      if (response.success) {
        this.push(this.editing ? 'Aanbieding bijgewerkt' : 'Aanbieding aangemaakt');

        await this.$router.push('/kassa/aanbiedingen');
      } else {
        this.push(this.editing ? 'Aanbieding niet bijgewerkt' : 'Aanbieding niet aangemaakt');
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
  }
</script>

<style scoped lang="scss">
  .grid {
    display: grid;
    grid-template: auto fit-content(1rem) / 3fr 2fr;
    grid-gap: 1rem;
    height: calc(100vh - 6rem);
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

  .heading {
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
