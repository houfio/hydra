<template>
  <div class="group">
    <slot/>
  </div>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  @Component
  export default class Group extends Vue {}
</script>

<style scoped lang="scss">
  .group {
    display: flex;

    & > * {
      border-radius: 0;

      &:first-child {
        border-top-left-radius: .5rem;
        border-bottom-left-radius: .5rem;
      }

      &:last-child {
        border-top-right-radius: .5rem;
        border-bottom-right-radius: .5rem;
      }
    }
  }
</style>
