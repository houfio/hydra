<template>
  <main class="page">
    <slot/>
  </main>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  @Component
  export default class Page extends Vue {}
</script>

<style scoped lang="scss">
  .page {
    padding: 1rem;
    min-height: calc(100vh - 4rem);
  }
</style>
