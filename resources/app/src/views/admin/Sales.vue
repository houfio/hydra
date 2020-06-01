<template>
  <Page>
    <div class="grid">
      <div class="box">
        <Form @submit="submit" v-slot="{ loading, errors }">
          <Input label="Startdatum" type="date" v-model="start" :errors="errors['start_date']"/>
          <Input label="Einddatum" type="date" v-model="end" :errors="errors['end_date']"/>
          <Button :disabled="loading">
            Maak overzicht
          </Button>
        </Form>
      </div>
      <div class="box">
        <div v-if="returned" class="spacing">
          <div class="info">
            <span class="big">
              &euro;{{ response.revenue.toFixed(2) }}
            </span>
            omzet incl. btw
          </div>
          <div class="info">
            <span class="big">
              &euro;{{ response.vat.toFixed(2) }}
            </span>
            btw
          </div>
          <div class="info">
            <span class="big">
              &euro;{{ (response.revenue - response.vat).toFixed(2) }}
            </span>
            omzet excl. btw
          </div>
        </div>
      </div>
      <div class="box big">
        <table>
        </table>
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
  import { ReportApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      Button,
      Form,
      Input
    }
  })
  export default class Sales extends Vue {
    public start = '';
    public end = '';
    public response: Partial<ReportApi> = {};

    get returned() {
      return Boolean(Object.keys(this.response).length);
    }

    public async submit(api: typeof request) {
      const response = await api<ReportApi>('/report', Method.Get, {
        start_date: this.start,
        end_date: this.end
      });

      if (response.success) {
        this.response = response.data;
      }
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
</style>
