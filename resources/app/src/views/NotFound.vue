<template>
  <Page>
    404 - niet gevonden
  </Page>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Page from '../components/Page.vue';

  @Component({
    components: {
      Page
    }
  })
  export default class NotFound extends Vue {}
</script>
