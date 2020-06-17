<template>
  <component :is="tag" class="ugly" :bind="$props">
    <slot/>
  </component>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Prop } from 'vue-property-decorator';

  @Component
  export default class UglyButton extends Vue {
    @Prop({ default: 'button' }) public tag!: string;
  }
</script>

<style scoped lang="scss">
  .ugly {
    display: inline-block;
    width: 130px;
    color: white;
    background-image: linear-gradient(#00f4ff, #0054ff);
    font-size: 20px;
    text-align: center;
    text-decoration: none;

    &:disabled, &.disabled {
      opacity: .5;
      pointer-events: none;
    }
  }
</style>
