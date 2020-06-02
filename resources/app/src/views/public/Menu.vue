<template>
  <Page>
    <embed v-if="returned" :src="response.url" type="application/pdf" width="100%" height="1000px"/>
  </Page>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Button from '../../components/form/Button.vue';
  import Page from '../../components/public/Page.vue';
  import { Method } from '../../constants';
  import { MenuApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      Button
    }
  })
  export default class Menu extends Vue {
    public response: Partial<MenuApi> = {};

    get returned() {
      return Boolean(Object.keys(this.response).length);
    }

    public async mounted() {
      const response = await request<MenuApi>('/menu/current', Method.Get);

      if (response.success) {
        this.response = response.data;
      }
    }
  }
</script>
