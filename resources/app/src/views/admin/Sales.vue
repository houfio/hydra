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
        <div class="spacing">
          <div class="info">
            <span class="big">
              {{ returned ? `&euro;${response.revenue.toFixed(2)}` : '-' }}
            </span>
            omzet incl. btw
          </div>
          <div class="info">
            <span class="big">
              {{ returned ? `&euro;${response.vat.toFixed(2)}` : '-' }}
            </span>
            btw
          </div>
          <div class="info">
            <span class="big">
              {{ returned ? `&euro;${(response.revenue - response.vat).toFixed(2)}` : '-' }}
            </span>
            omzet excl. btw
          </div>
        </div>
      </div>
      <div class="box big">
        <Loader v-if="creating"/>
        <table v-else class="table">
          <colgroup>
            <col style="width: 20%"/>
            <col style="width: 50%"/>
            <col/>
            <col/>
            <col/>
          </colgroup>
          <thead>
            <tr>
              <th class="heading">
                Datum
              </th>
              <th class="heading">
                Gerecht
              </th>
              <th class="heading right">
                Prijs
              </th>
              <th class="heading right">
                Aantal
              </th>
              <th class="heading right">
                Subtotaal
              </th>
            </tr>
          </thead>
          <tbody v-if="returned">
            <tr v-for="dish of response.dishes.data">
              <td class="data">
                {{ format(dish.order.created_at) }}
              </td>
              <td class="data">
                {{ dish.dish ? dish.dish.name : 'Product verwijderd' }}
              </td>
              <td class="data right">
                &euro;{{ dish.price.toFixed(2) }}
              </td>
              <td class="data right">
                {{ dish.quantity }}
              </td>
              <td class="data right">
                &euro;{{ (dish.price * dish.quantity).toFixed(2) }}
              </td>
            </tr>
          </tbody>
        </table>
        <div class="paginator">
          <Paginator v-if="returned" :paginated="response.dishes" @paginate="paginate"/>
        </div>
      </div>
    </div>
  </Page>
</template>

<script lang="ts">
  import { format, parseISO } from 'date-fns';
  import { nl } from 'date-fns/locale';
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Page from '../../components/admin/Page.vue';
  import Button from '../../components/form/Button.vue';
  import Form from '../../components/form/Form.vue';
  import Input from '../../components/form/Input.vue';
  import Loader from '../../components/Loader.vue';
  import Paginator from '../../components/Paginator.vue';
  import { Method } from '../../constants';
  import { ReportApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      Button,
      Form,
      Input,
      Paginator,
      Loader
    }
  })
  export default class Sales extends Vue {
    public start = '';
    public end = '';
    public response: Partial<ReportApi> = {};
    public creating = false;

    get returned() {
      return Boolean(Object.keys(this.response).length);
    }

    public async submit(api: typeof request, page?: number) {
      this.creating = true;

      const response = await api<ReportApi>('/report', Method.Get, {
        start_date: this.start,
        end_date: this.end,
        page
      });

      if (response.success) {
        this.response = response.data;
      }

      this.creating = false;
    }

    public paginate(page: number) {
      this.submit(request, page);
    }

    public format(date: string) {
      return format(parseISO(date), 'PPpp', { locale: nl });
    }
  }
</script>

<style scoped lang="scss">
  .grid {
    display: grid;
    grid-template: 12rem calc(100vh - 19rem) / 1fr 2fr;
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

  .table {
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
  }

  .heading {
    text-align: start;
    padding-bottom: .5rem;
  }

  .data {
    padding: .5rem 0;
  }

  .right {
    text-align: right;
  }

  .paginator {
    display: flex;
    justify-content: flex-end;
    margin-top: .5rem;
  }
</style>
