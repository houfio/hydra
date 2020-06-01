<template>
  <Page>
    <div class="grid">
      <div class="box">
        <form @submit.prevent="submit">
          <Input label="Startdatum" type="date" v-model="start" :errors="errors['start_date']"/>
          <Input label="Einddatum" type="date" v-model="end" :errors="errors['end_date']"/>
          <Button :disabled="loading">
            Maak overzicht
          </Button>
        </form>
      </div>
      <div class="box">
        lol
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
  import Input from '../../components/form/Input.vue';
  import { Method } from '../../constants';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      Button,
      Input
    }
  })
  export default class Sales extends Vue {
    public start = '';
    public end = '';
    public errors = {};
    public loading = false;

    public async submit() {
      this.loading = true;

      await request('/report', Method.Get, {
        start_date: this.start,
        end_date: this.end
      });

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
