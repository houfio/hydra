<template>
  <Page>
    sales
  </Page>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Page from '../../components/admin/Page.vue';

  @Component({
    components: {
      Page
    }
  })
  export default class Sales extends Vue {}
</script>

<style scoped lang="scss">
</style>
