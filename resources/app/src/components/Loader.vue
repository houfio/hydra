<template>
  <div class="loader"/>
</template>

<script>
  import Vue from 'vue';
  import Component from 'vue-class-component';

  @Component
  export default class Loader extends Vue {}
</script>

<style scoped lang="scss">
  .loader {
    margin: 0 auto;
    border: .25rem solid rgba(255, 255, 255, .25);;
    border-top-color: white;
    border-left-color: white;
    border-radius: 50%;
    width: 2rem;
    height: 2rem;
    animation: spin .5s linear infinite;
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
