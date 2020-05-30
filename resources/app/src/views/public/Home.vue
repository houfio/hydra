<template>
  <Page>
    Home
  </Page>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Page from '../../components/public/Page.vue';

  @Component({
    components: {
      Page
    }
  })
  export default class Home extends Vue {}
</script>
