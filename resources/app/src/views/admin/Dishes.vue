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
              <Button @click.native="removeDish(dish)">
                Verwijderen
              </Button>
            </div>
            <div>
              <Button @click.native="selectedDish = {...dish, type_id: type.id}">
                Aanpassen
              </Button>
            </div>
          </div>
        </div>
      </div>
      <div class="box">
        <span>Product toevoegen</span>
        <Form @submit="createDish" v-slot="{ loading, errors }">
          <Input label="Naam" type="text" v-model="newDish.name" :errors="errors['name']"/>
          <Input label="Prijs" type="number" v-model.number="newDish.price" :errors="errors['price']" step="0.01"/>
          <Input label="Menu nummer" type="text" v-model="newDish.number" :errors="errors['number']"/>
          <Input label="Beschrijving" type="textarea" v-model="newDish.description" :errors="errors['description']"/>
          <Input
            label="Type"
            type="select"
            v-model="newDish.type_id"
            :errors="errors['type_id']"
            :options="typeOptions"
          />
          <Button :disabled="loading">
            Aanmaken
          </Button>
        </Form>
      </div>
      <div class="box">
        <span>Product Aanpassen</span>
        <p v-if="!Object.keys(selectedDish).length">Geen product geselecteerd</p>
        <Form v-else @submit="updateDish" v-slot="{ loading, errors }">
          <Input label="Naam" type="text" v-model="selectedDish.name" :errors="errors['name']"/>
          <Input label="Prijs" type="number" v-model.number="selectedDish.price" :errors="errors['price']" step="0.01"/>
          <Input label="Menu nummer" type="text" v-model="selectedDish.number" :errors="errors['number']"/>
          <Input
            label="Beschrijving"
            type="textarea"
            v-model="selectedDish.description"
            :errors="errors['description']"
          />
          <Input
            label="Type"
            type="select"
            v-model="selectedDish.type_id"
            :errors="errors['type_id']"
            :data="types.flatMap((type) => [{id: type.id, label: type.name}])"
          />
          <Button :disabled="loading">
            Aanpassen
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
  import { Method } from '../../constants';
  import { Dish, DishesApi, DishType } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      Button,
      Form,
      Input
    }
  })
  export default class Dishes extends Vue {
    public types: DishType[] = [];
    public selectedDish: Partial<Dish> = {};
    public selectedType: Partial<DishType> = {};
    public newDish = {
      name: '',
      description: '',
      number: '',
      price: 0,
      type_id: 0
    };
    public newType = '';

    @Mutation('push', {namespace: 'notification'})
    private push!: (notification: string) => void;

    public get typeOptions() {
      return this.types.reduce((previous, current) => ({
        ...previous,
        [current.id]: current.name
      }), {});
    }

    public async mounted() {
      await this.getDishes();
    }

    public async createDish(api: typeof request) {
      const response = await api('/dishes', Method.Post, this.newDish);

      if (response.success) {
        await this.getDishes();
        this.push('Product aangemaakt');
      } else {
        this.push('Product niet aangemaakt');
      }
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

    public async updateDish(api: typeof request) {
      const response = await api(`/dishes/${this.selectedDish.id}`, Method.Put, this.selectedDish);

      if (response.success) {
        await this.getDishes();
        this.push('Product bijgewerkt');
      } else {
        this.push('Product niet bijgewerkt');
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
    grid-template: repeat(2, calc(50vh - 3.5rem)) / 3fr 2fr;
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
