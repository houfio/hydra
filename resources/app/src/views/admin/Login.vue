<template>
  <div class="center">
    <form class="form" @submit.prevent="submit">
      <Error v-if="error">
        {{ error }}
      </Error>
      <Input label="Nummer" type="number" v-model.number="id" :errors="errors['id']"/>
      <Input label="Wachtwoord" type="password" v-model="password" :errors="errors['password']"/>
      <Button type="submit">
        Inloggen
      </Button>
    </form>
  </div>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Mutation } from 'vuex-class';

  import Button from '../../components/form/Button.vue';
  import Error from '../../components/form/Error.vue';
  import Input from '../../components/form/Input.vue';
  import { Method, StatusCode } from '../../constants';
  import { FormErrors, LoginApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Button,
      Error,
      Input
    }
  })
  export default class Login extends Vue {
    public id = '';
    public password = '';
    public error = '';
    public errors = {};

    @Mutation('setToken', { namespace: 'auth' })
    private setToken!: (token?: string) => void;

    public async submit() {
      this.error = '';
      this.errors = {};

      const response = await request<LoginApi>('/auth/login', Method.Post, {
        id: this.id,
        password: this.password
      });

      if (response.success) {
        this.setToken(response.data.token);
        const redirect = this.$route.query.redirect;

        await this.$router.push(Array.isArray(redirect) || !redirect ? '/kassa' : redirect);
      } else {
        if (response.error.code !== StatusCode.UnprocessableEntity) {
          return this.error = response.error.message;
        }

        this.errors = response.error.info as FormErrors;
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

  .form {
    padding: 1rem;
    background-color: #262626;
    border-radius: 1rem;
  }
</style>
