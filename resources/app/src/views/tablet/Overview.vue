<template>
  <Page>
    <Menu :response="response" :icon="plus" @toggle="addDish" :tablet="true"/>
  </Page>
</template>

<script lang="ts">
  import { faPlus } from '@fortawesome/free-solid-svg-icons';
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Mutation } from 'vuex-class';

  import Menu from '../../components/Menu.vue';
  import Page from '../../components/Page.vue';
  import { Method } from '../../constants';
  import { MenuApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Menu,
      Page
    }
  })
  export default class Overview extends Vue {
    public response: Partial<MenuApi> = {};

    @Mutation('addDish', { namespace: 'cart' })
    private addDish!: (params: {id: number, isOffer: boolean}) => void;

    public get plus() {
      return faPlus;
    }

    public async mounted() {
      const response = await request<MenuApi>('/menu', Method.Get);

      if (response.success) {
        this.response = response.data;
      }
    }
  }
</script>
