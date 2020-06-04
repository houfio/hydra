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
        <span>Product toevoegen</span>
        <Form @submit="create" v-slot="{ loading, errors }">
          <Input label="Naam" type="text" v-model="newDish.name" :errors="errors['name']"/>
          <Input label="Prijs" type="number" v-model="newDish.price" :errors="errors['price']"/>
          <Input label="Menu nummer" type="text" v-model="newDish.number" :errors="errors['number']"/>
          <Input label="Beschrijving" type="textarea" v-model="newDish.description" :errors="errors['description']"/>
          <Input label="Type" type="select" v-model="newDish.type_id" :errors="errors['type_id']"/>
          <Button :disabled="loading">
            Aanmaken
          </Button>
        </Form>
      </div>
      <div class="box">
        <span>Product Aanpassen</span>
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
  import Input from '../../components/form/Input.vue';
  import { Method } from '../../constants';
  import { DishesApi, DishType, NewDish } from '../../types';
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
    public newDish: NewDish = {
      name: '',
      description: '',
      number: '',
      price: 0,
      type_id: 0
    };

    public async mounted() {
      const response = await request<DishesApi>('/dishes', Method.Get);

      if (response.success) {
        this.types = response.data.types;
      }
    }

    public async create() {
      const response = await request('/dishes', Method.Post, this.newDish);

      if (response.success) {
        window.alert('Product aangemaakt');
      } else {
        window.alert('Product niet aangemaakt');
      }
    }
  }
</script>

<style scoped lang="scss">
  .grid {
    display: grid;
    grid-template: repeat(2, calc(70vh - 19rem)) / 3fr 2fr;
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
    justify-content: start;
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
