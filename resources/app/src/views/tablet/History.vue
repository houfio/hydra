<template>
  <Page>
    {{ JSON.stringify(orders) }}
  </Page>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Page from '../../components/Page.vue';
  import { Method } from '../../constants';
  import { OrdersApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page
    }
  })
  export default class History extends Vue {
    public orders: Partial<OrdersApi> = {};

    public async mounted() {
      const response = await request<OrdersApi>('/orders', Method.Get);

      if (response.success) {
        this.orders = response.data;
      }
    }
  }
</script>
