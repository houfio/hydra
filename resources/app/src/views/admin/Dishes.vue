<template>
  <Page>
    <div class="grid">
      <Form @submit="getDishes" v-slot="{ loading }">
        <Group class="group">
          <Input label="Zoeken" :spacing="false" v-model="search"/>
          <Button :disabled="loading">
            Gerecht zoeken
          </Button>
        </Group>
      </Form>
      <Button @click.native="$router.push('/kassa/gerechten/nieuw')">
        Gerecht aanmaken
      </Button>
      <Button @click.native="$router.push('/kassa/types')">
        Gerecht types
      </Button>
      <div class="box big">
        <Loader v-if="loading"/>
        <div v-else v-for="type of types.types">
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
            <Group>
              <Button @click.native="removeDish(dish)">
                Verwijderen
              </Button>
              <Button @click.native="$router.push(`/kassa/gerechten/${dish.id}`)">
                Aanpassen
              </Button>
            </Group>
          </div>
        </div>
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
  import Group from '../../components/form/Group.vue';
  import Input from '../../components/form/Input.vue';
  import Loader from '../../components/Loader.vue';
  import { Method } from '../../constants';
  import { Dish, DishesApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      Button,
      Form,
      Group,
      Input,
      Loader
    }
  })
  export default class Dishes extends Vue {
    public types: Partial<DishesApi> = {};
    public search = '';

    @Mutation('push', {namespace: 'notification'})
    private push!: (notification: string) => void;

    public get loading() {
      return !Object.keys(this.types).length;
    }

    public async mounted() {
      await this.getDishes();
    }

    public async removeDish(dish: Dish) {
      const deleted = await request(`/dishes/${dish.id}`, Method.Delete);

      if (deleted) {
        await this.getDishes();
        this.push('Product verwijderd');
      } else {
        this.push('Product niet aangemaakt');
      }
    }

    private async getDishes(api = request) {
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
    grid-template: 3rem calc(100vh - 10rem) / 5fr 1fr 1fr;
    grid-gap: 1rem;
  }

  .box {
    padding: 1rem;
    background-color: #262626;
    border-radius: 1rem;

    &.big {
      grid-column: span 3;
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

  .group {
    display: flex;

    & > *:nth-child(1) {
      flex: 5;
    }

    & > *:nth-child(2) {
      flex: 1;
    }
  }
</style>
