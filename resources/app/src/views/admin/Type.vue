<template>
  <Page>
    <div class="box">
      <Form @submit="submit" v-slot="{ loading, errors }">
        <Input label="Naam" type="text" v-model="type.name" :errors="errors['name']"/>
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
  import { Method } from '../../constants';
  import { Type as SingleType, TypeApi } from '../../types';
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
    public type: SingleType = {
      name: ''
    };

    @Mutation('push', { namespace: 'notification' })
    private push!: (notification: string) => void;

    public get id() {
      return parseInt(this.$route.params.id, 10);
    }

    public get editing() {
      return !isNaN(this.id);
    }

    public async mounted() {
      if (this.editing) {
        const response = await request<TypeApi>(`/types/${this.id}`, Method.Get);

        if (response.success) {
          this.type = response.data.type;
        }
      }
    }

    public async submit(api: typeof request) {
      const response = this.editing ?
        await api(`/types/${this.type.id}`, Method.Put, this.type) :
        await api('/types', Method.Post, this.type);

      if (response.success) {
        this.push(this.editing ? 'Product type bijgewerkt' : 'Product type aangemaakt');

        await this.$router.push('/kassa/types');
      } else {
        this.push(this.editing ? 'Product type niet bijgewerkt' : 'Product type niet aangemaakt');
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
