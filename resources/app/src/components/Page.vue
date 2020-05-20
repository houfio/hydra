<template>
  <td class="page">
    <slot/>
  </td>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  @Component
  export default class Page extends Vue {}
</script>

<style scoped lang="scss">
  .page {
    background-color: floralwhite;
    border: 1px solid black;
  }
</style>
