<template>
  <Page>
    <div class="box">
      <Loader v-if="loading"/>
      <Form v-else @submit="submit" v-slot="{ loading, errors }">
        <Input label="Naam" type="text" v-model="dish.name" :errors="errors['name']"/>
        <Input label="Prijs" type="number" v-model.number="dish.price" :errors="errors['price']" step="0.01"/>
        <Input label="Menu nummer" type="text" v-model="dish.number" :errors="errors['number']"/>
        <Input label="Beschrijving" type="textarea" v-model="dish.description" :errors="errors['description']"/>
        <Input
          label="Type"
          type="select"
          v-model="dish.type_id"
          :errors="errors['type_id']"
          :options="types"
        />
        <Button :disabled="loading">
          {{ editing ? 'Bewerken' : 'Aanmaken' }}
        </Button>
      </Form>
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
  import { Dish as SingleDish, DishApi, DishesApi } from '../../types';
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
  export default class Dish extends Vue {
    public dish: SingleDish = {
      number: '',
      description: '',
      name: '',
      type_id: 1,
      price: 0
    };
    public response: Partial<DishesApi> = {};

    @Mutation('push', { namespace: 'notification' })
    private push!: (notification: string) => void;

    public get loading() {
      return !Object.keys(this.response).length;
    }

    public get types() {
      return this.response.types?.reduce((previous, current) => ({
        ...previous,
        [current.id || -1]: current.name
      }), {}) || {};
    }

    public get id() {
      return parseInt(this.$route.params.id, 10);
    }

    public get editing() {
      return !isNaN(this.id);
    }

    public async mounted() {
      const [types, dish] = await Promise.all([
        request<DishesApi>('/dishes', Method.Get),
        this.editing ? request<DishApi>(`/dishes/${this.id}`, Method.Get) : undefined
      ]);

      if (types.success) {
        this.response = types.data;
      }

      if (dish?.success) {
        this.dish = dish.data.dish;
      }
    }

    public async submit(api: typeof request) {
      const response = this.editing
        ? await api(`/dishes/${this.id}`, Method.Put, this.dish)
        : await api('/dishes', Method.Post, this.dish);

      if (response.success) {
        this.push(this.editing ? 'Product bijgewerkt' : 'Product aangemaakt');

        await this.$router.push('/kassa/gerechten');
      } else {
        this.push(this.editing ? 'Product niet bijgewerkt' : 'Product niet aangemaakt');
      }
    }
  }
</script>

<style scoped lang="scss">
  .box {
    padding: 1rem;
    background-color: #262626;
    border-radius: 1rem;
  }
</style>
