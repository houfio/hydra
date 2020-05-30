<template>
  <button class="button">
    <slot/>
  </button>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  @Component
  export default class Button extends Vue {}
</script>

<style scoped lang="scss">
  .button {
    display: block;
    width: 100%;
    padding: .5rem .75rem;
    background-color: #ff6347;
    border-radius: .5rem;
    text-align: center;
    outline: none;
    transition: box-shadow .25s ease;

    &:focus {
      box-shadow: 0 0 0 3px darken(#ff6347, 25);
    }
  }
</style>
