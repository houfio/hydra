<template>
  <div class="error">
    <slot/>
  </div>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  @Component
  export default class Error extends Vue {}
</script>

<style scoped lang="scss">
  .error {
    margin-bottom: .5rem;
    padding: .5rem .75rem;
    color: white;
    background-color: red;
    border-radius: .5rem;
    font-family: 'Open Sans', sans-serif;
  }
</style>
