<template>
  <form @submit.prevent="submit">
    <Error v-if="error">
      {{ error }}
    </Error>
    <slot :loading="loading" :errors="errors"/>
  </form>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import { StatusCode } from '../../constants';
  import { FormErrors, FunctionArguments } from '../../types';
  import { request } from '../../utils/request';

  import Error from './Error.vue';

  @Component({
    components: {
      Error
    }
  })
  export default class Form extends Vue {
    public error = '';
    public errors = {};
    public loading = false;

    public async submit() {
      this.error = '';
      this.errors = {};
      this.loading = true;

      await new Promise((resolve) => {
        this.$emit('submit', async (...args: FunctionArguments<typeof request>) => {
          const response = await request(...args);

          if (!response.success) {
            const error = (response as any).error;

            if (error.code !== StatusCode.UnprocessableEntity) {
              this.error = error.message;
            } else {
              this.errors = error.info as FormErrors;
            }
          }

          resolve(response);

          return response;
        });
      });

      this.loading = false;
    }
  }
</script>
