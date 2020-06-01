<template>
  <Page>
    <div class="grid">
      <div class="box big">
        bruh
      </div>
      <div class="box">
        bruh
      </div>
      <div class="box">
        bruh
      </div>
    </div>
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
  export default class Dashboard extends Vue {}
</script>

<style scoped lang="scss">
  .grid {
    display: grid;
    grid-template: calc(100vh - 19rem) 12rem / 3fr 2fr;
    grid-gap: 1rem;
  }

  .box {
    padding: 1rem;
    background-color: #262626;
    border-radius: 1rem;

    &.big {
      grid-row: span 2;
      overflow-y: scroll;
    }
  }
</style>
