<template>
  <Page>
    <div class="grid">
      <div class="box">
        <form @submit.prevent="submit">
          <Error v-if="error">
            {{ error }}
          </Error>
          <Input label="Startdatum" type="date" v-model="start" :errors="errors['start_date']"/>
          <Input label="Einddatum" type="date" v-model="end" :errors="errors['end_date']"/>
          <Button :disabled="loading">
            Maak overzicht
          </Button>
        </form>
      </div>
      <div class="box">
        <div v-if="response">
          revenue:
          {{ response.revenue }}
          vat: 
          {{ response.vat }}
        </div>
      </div>
      <div class="box big">
        lol
      </div>
    </div>
  </Page>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Page from '../../components/admin/Page.vue';
  import Button from '../../components/form/Button.vue';
  import Error from '../../components/form/Error.vue';
  import Input from '../../components/form/Input.vue';
  import { Method, StatusCode } from '../../constants';
  import { FormErrors, ReportApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      Button,
      Error,
      Input
    }
  })
  export default class Sales extends Vue {
    public start = '';
    public end = '';
    public error = '';
    public errors = {};
    public loading = false;
    public response?: ReportApi;

    public async submit() {
      this.loading = true;

      const response = await request<ReportApi>('/report', Method.Get, {
        start_date: this.start,
        end_date: this.end
      });

      if (response.success) {
        this.response = response.data;
      } else {
        if (response.error.code !== StatusCode.UnprocessableEntity) {
          return this.error = response.error.message;
        }

        this.errors = response.error.info as FormErrors;
      }

      this.loading = false;
    }
  }
</script>

<style scoped lang="scss">
  .grid {
    display: grid;
    grid-template: auto minmax(25rem, 1fr) / 1fr 2fr;
    grid-gap: 1rem;
  }

  .box {
    padding: 1rem;
    background-color: #262626;
    border-radius: 1rem;

    &.big {
      grid-column: span 2;
    }
  }
</style>
