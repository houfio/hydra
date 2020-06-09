<template>
  <Page>
    <div class="grid">
      <div/>
      <span>{{ editing ? 'Product bewerken' : 'Product toevoegen' }}</span>
      <div class="box big">
        <Form @submit="submit" v-slot="{ loading, errors }">
          <Input label="Naam" type="text" v-model="dish.name" :errors="errors['name']"/>
          <Input label="Prijs" type="number" v-model.number="dish.price" :errors="errors['price']" step="0.01"/>
          <Input label="Menu nummer" type="text" v-model="dish.number" :errors="errors['number']"/>
          <Input label="Beschrijving" type="textarea" v-model="dish.description" :errors="errors['description']"/>
          <Input
              label="Type"
              type="select"
              v-model="dish.type_id"
              :errors="errors['type_id']"
              :options="typeOptions"
          />
          <Button :disabled="loading">
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
  import { Method } from '../../constants';
  import { DishApi, DishesApi, DishType } from '../../types';
  import { Dish as SingleDish } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      Button,
      Form,
      Input
    }
  })
  export default class Dish extends Vue {
    public dish: SingleDish = {
      number: '',
      description: '',
      name: '',
      type_id: 1,
      price: 0
    };
    public types: DishType[] = [];

    @Mutation('push', {namespace: 'notification'})
    private push!: (notification: string) => void;

    public get typeOptions() {
      return this.types.reduce((previous, current) => ({
        ...previous,
        [current.id]: current.name
      }), {});
    }

    public get editing() {
      return Boolean(this.$route.params.id);
    }

    public async mounted() {
      if (this.editing) {
        await this.getDish(this.$route.params.id);
      }

      const response = await request<DishesApi>('/dishes', Method.Get);

      if (response.success) {
        this.types = response.data.types;
      }
    }

    public async submit(api: typeof request) {
      const response = this.editing ?
        await api(`/dishes/${this.dish.id}`, Method.Put, this.dish) :
        await api('/dishes', Method.Post, this.dish);

      if (response.success) {
        this.push(this.editing ? 'Product bijgewerkt' : 'Product aangemaakt');
      } else {
        this.push(this.editing ? 'Product niet bijgewerkt' : 'Product niet aangemaakt');
      }
    }

    private async getDish(id: string) {
      const response = await request<DishApi>(`/dishes/${id}`, Method.Get);

      if (response.success) {
        this.dish = response.data.dish;
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
</style>
