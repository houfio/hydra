<template>
  <Page>
    <Menu :response="response"/>
  </Page>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import UglyButton from '../../components/form/UglyButton.vue';
  import Menu from '../../components/Menu.vue';
  import Page from '../../components/Page.vue';
  import { Method } from '../../constants';
  import { MenuApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      UglyButton,
      Menu,
      Page
    }
  })
  export default class Overview extends Vue {
    public response: Partial<MenuApi> = {};

    public async mounted() {
      const response = await request<MenuApi>('/menu', Method.Get);

      if (response.success) {
        this.response = response.data;
      }
    }
  }
</script>
