<template>
  <Page>
    <div class="grid">
      <div/>
      <Button @click.native="$router.push('/kassa/gerechten/maken')">
        Aanmaken
      </Button>
      <div class="box big">
        <Loader v-if="!types.length"/>
        <div v-else v-for="type of types">
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
              <Button @click.native="removeDish(dish)">
                Verwijderen
              </Button>
            </div>
            <div>
              <Button @click.native="$router.push(`/kassa/gerechten/maken/${dish.id}`)">
                Aanpassen
              </Button>
            </div>
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
  import Input from '../../components/form/Input.vue';
  import Loader from '../../components/Loader.vue';
  import { Method } from '../../constants';
  import { Dish, DishesApi, DishType } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      Button,
      Form,
      Input,
      Loader
    }
  })
  export default class Dishes extends Vue {
    public types: DishType[] = [];
    public selectedType: Partial<DishType> = {};
    public newType = '';

    @Mutation('push', {namespace: 'notification'})
    private push!: (notification: string) => void;

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

    public async createType() {
      const response = await request('/types', Method.Post, {
        name: this.newType
      });

      if (response.success) {
        await this.getDishes();
        this.push('Product type aangemaakt');
      } else {
        this.push('Product type niet aangemaakt');
      }
    }

    public async removeType(type: DishType) {
      const deleted = await request(`/types/${type.id}`, Method.Delete);

      if (deleted) {
        await this.getDishes();
        this.push('Product type verwijderd');
      } else {
        this.push('Product type niet verwijderd');
      }
    }

    public async updateType() {
      const response = await request(`/types/${this.selectedType.id}`, Method.Put, this.selectedType);

      if (response.success) {
        await this.getDishes();
        this.push('Product type bijgewerkt');
      } else {
        this.push('Product type niet bijgewerkt');
      }
    }

    private async getDishes() {
      const response = await request<DishesApi>('/dishes', Method.Get);

      if (response.success) {
        this.types = response.data.types;
      }
    }
  }
</script>

<style scoped lang="scss">
  .grid {
    display: grid;
    grid-template: 3rem calc(100vh - 11rem) / 5fr 1fr;
    grid-gap: 1rem;
  }

  .box {
    padding: 1rem;
    background-color: #262626;
    border-radius: 1rem;

    &.big {
      grid-column: span 2;
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
