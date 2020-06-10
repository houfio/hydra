<template>
  <Page>
    <div class="box">
      <span class="message">
        Door de Corona crisis is De Gouden Draak op het moment slechts beperkt open.
        Het restaurant-gedeelte is gesloten.
        U kan uw favorieten gerechten nog wel afhalen.
      </span>
    </div>
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
  export default class News extends Vue {
  }
</script>

<style scoped lang="scss">
  .box {
    padding: 2rem;
    text-align: center;

    .message {
      font-weight: bold;
    }
  }
</style>
