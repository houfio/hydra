<template>
  <button class="button" :bind="$props">
    <slot/>
  </button>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Prop } from 'vue-property-decorator';

  @Component
  export default class Button extends Vue {}
</script>

<style scoped lang="scss">
  .button {
    display: block;
    width: 100%;
    padding: .5rem .75rem;
    color: white;
    background-color: #ff6347;
    border-radius: .5rem;
    font-family: 'Open Sans', sans-serif;
    text-align: center;
    outline: none;
    transition: box-shadow .25s ease, opacity .25s ease;

    &:focus {
      box-shadow: 0 0 0 3px darken(#ff6347, 25);
    }

    &:disabled {
      pointer-events: none;
      opacity: .5;
    }
  }
</style>
