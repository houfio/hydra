<template>
  <td class="page" :style="{ padding: padding }">
    <slot/>
  </td>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Prop } from 'vue-property-decorator';

  @Component
  export default class Page extends Vue {
    @Prop({ default: '0px' }) public padding!: string;
  }
</script>

<style scoped lang="scss">
  .page {
    background-color: floralwhite;
    border: 1px solid black;
  }
</style>
