<template>
  <div class="center">
    <div class="box">
      <Form @submit="submit" v-slot="{ loading, errors }">
        <Input label="Nummer" type="number" v-model.number="id" :errors="errors['id']"/>
        <Input label="Wachtwoord" type="password" v-model="password" :errors="errors['password']"/>
        <Button :disabled="loading">
          Inloggen
        </Button>
      </Form>
    </div>
  </div>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Mutation } from 'vuex-class';

  import Button from '../../components/form/Button.vue';
  import Form from '../../components/form/Form.vue';
  import Input from '../../components/form/Input.vue';
  import { Method } from '../../constants';
  import { LoginApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Button,
      Form,
      Input
    }
  })
  export default class Login extends Vue {
    public id = '';
    public password = '';

    @Mutation('setToken', { namespace: 'auth' })
    private setToken!: (token?: string) => void;

    public async submit(api: typeof request) {
      const response = await api<LoginApi>('/auth/login', Method.Post, {
        id: this.id,
        password: this.password
      });

      if (response.success) {
        this.setToken(response.data.token);
        const redirect = this.$route.query.redirect;

        this.$router.push(Array.isArray(redirect) || !redirect ? '/kassa' : redirect);
      }
    }
  }
</script>

<style scoped lang="scss">
  .center {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
  }

  .box {
    padding: 1rem;
    background-color: #262626;
    border-radius: 1rem;
  }
</style>
