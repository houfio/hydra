<template>
  <Page>
    <div class="grid">
      <div/>
      <span>{{ editing ? 'Product type bewerken' : 'Product type toevoegen' }}</span>
      <div class="box big">
        <Form @submit="submit" v-slot="{ loading, errors }">
          <Input label="Naam" type="text" v-model="type.name" :errors="errors['name']"/>
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
  import { DishType, TypeApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      Button,
      Form,
      Input
    }
  })
  export default class Type extends Vue {
    public type: DishType = {
      id: 1,
      name: ''
    };

    @Mutation('push', {namespace: 'notification'})
    private push!: (notification: string) => void;

    public get editing() {
      return Boolean(this.$route.params.id);
    }

    public async mounted() {
      if (this.editing) {
        await this.getType(this.$route.params.id);
      }
    }

    public async submit(api: typeof request) {
      const response = this.editing ?
        await api(`/types/${this.type.id}`, Method.Put, this.type) :
        await api('/types', Method.Post, this.type);

      if (response.success) {
        this.push(this.editing ? 'Product type bijgewerkt' : 'Product type aangemaakt');
      } else {
        this.push(this.editing ? 'Product type niet bijgewerkt' : 'Product type niet aangemaakt');
      }
    }

    private async getType(id: string) {
      const response = await request<TypeApi>(`/types/${id}`, Method.Get);

      if (response.success) {
        this.type = response.data.type;
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
