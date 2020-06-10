<template>
  <div class="loader"/>
</template>

<script>
  import Vue from 'vue';
  import Component from 'vue-class-component';

  @Component
  export default class Loader extends Vue {
  }
</script>

<style scoped lang="scss">
  .loader {
    margin: 0 auto;
    border: 8px solid #f3f3f3;
    border-top: 8px solid #555;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: spin 2s linear infinite;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }
    100% {
      transform: rotate(360deg);
    }
  }
</style>
