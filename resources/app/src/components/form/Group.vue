<template>
  <div class="group" :bind="$attrs">
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
      border-radius: 0 !important;

      &:first-child {
        border-top-left-radius: .5rem !important;
        border-bottom-left-radius: .5rem !important;
      }

      &:last-child {
        border-top-right-radius: .5rem !important;
        border-bottom-right-radius: .5rem !important;
      }
    }
  }
</style>
