<template>
  <Page>
    <div class="grid">
      <Form class="top" @submit="getDishes" v-slot="{ loading }">
        <Group class="group">
          <Input label="Zoeken" :spacing="false" v-model="search"/>
          <Button :disabled="loading">
            Gerecht zoeken
          </Button>
        </Group>
      </Form>
      <div class="box big">
        <Loader v-if="loading"/>
        <div v-else>
          <div v-for="type of types.types">
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
          <span class="heading">
            Aanbiedingen
          </span>
          <div v-for="offer of offers.offers">
            <div class="dish">
              <div style="width: 0"/>
              <div>
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
              <div/>
              <i>
                {{ dish.name }}
              </i>
              <div/>
              <div/>
            </div>
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
            <Input label="Notitie" type="text" v-model="dish.note"/>
          </div>
          <div>
            &euro;{{ dish.price.toFixed(2) }}
          </div>
          <Group>
            <Button @click.native="remove(dish)">
              <FontAwesomeIcon :icon="minus"/>
            </Button>
            <Button @click.native="add(dish)">
              <FontAwesomeIcon :icon="plus"/>
            </Button>
          </Group>
        </div>
      </div>
      <div class="box">
        <div class="spacing">
          <div class="info">
            <span class="big">
              &euro;{{ total }}
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
  import { faMinus, faPlus } from '@fortawesome/free-solid-svg-icons';
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Mutation } from 'vuex-class';

  import Page from '../../components/admin/Page.vue';
  import Button from '../../components/form/Button.vue';
  import Form from '../../components/form/Form.vue';
  import Group from '../../components/form/Group.vue';
  import Input from '../../components/form/Input.vue';
  import Loader from '../../components/Loader.vue';
  import { Method } from '../../constants';
  import { DishesApi, OffersApi, OrderApi, OrderDish } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      FontAwesomeIcon,
      Page,
      Button,
      Form,
      Group,
      Input,
      Loader
    }
  })
  export default class Dashboard extends Vue {
    public types: Partial<DishesApi> = {};
    public offers: Partial<OffersApi> = {};
    public order: OrderDish[] = [];
    public search = '';

    @Mutation('push', { namespace: 'notification' })
    private push!: (notification: string) => void;

    public get loading() {
      return !Object.keys(this.types).length || !Object.keys(this.offers).length;
    }

    public get total() {
      return this.order.reduce((previous, { price, quantity }) => previous + price * quantity, 0).toFixed(2);
    }

    public get plus() {
      return faPlus;
    }

    public get minus() {
      return faMinus;
    }

    public async mounted() {
      const [types, offers] = await Promise.all([
        request<DishesApi>('/dishes', Method.Get),
        request<OffersApi>('/offers', Method.Get)
      ]);

      if (types.success) {
        this.types = types.data;
      }

      if (offers.success) {
        this.offers = offers.data;
      }
    }

    public add(dish: OrderDish) {
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
        foundDish.quantity++;
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
        foundDish.quantity--;
      }
    }

    public deleteOrder() {
      this.order = [];
      this.push('Bestelling verwijderd');
    }

    public async pay() {
      const response = await request<OrderApi>('/orders', Method.Post, {
        dishes: this.order.filter((line) => !line.isOffer),
        offers: this.order.filter((line) => line.isOffer)
      });

      if (response.success) {
        this.order = [];
        this.push(`Bestelling aangemaakt met bestelnummer: ${response.data.order}`);
      } else {
        this.push('Bestellig niet aangemaakt');
      }
    }

    private async getDishes(api: typeof request) {
      const response = await api<DishesApi>(`/dishes?q=${encodeURIComponent(this.search)}`, Method.Get);

      if (response.success) {
        this.types = response.data;
      }
    }
  }
</script>

<style scoped lang="scss">
  .grid {
    display: grid;
    grid-template: 1fr 18fr 5fr / 3fr 2fr;
    grid-gap: 1rem;
    height: calc(100vh - 6rem);
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

  .top {
    grid-column: span 2;
  }

  .group {
    display: flex;

    & > *:nth-child(1) {
      flex: 5;
    }

    & > *:nth-child(2) {
      flex: 1;
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
