<template>
  <button class="button">
    <slot/>
  </button>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  @Component
  export default class UglyButton extends Vue {}
</script>

<style scoped lang="scss">
  .button {
    display: inline-block;
    width: 130px;
    color: white;
    background-image: linear-gradient(#00f4ff, #0054ff);
    font-size: 20px;
    text-align: center;
    text-decoration: none;
  }
</style>
