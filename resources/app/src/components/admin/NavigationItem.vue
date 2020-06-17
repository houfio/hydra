<template>
  <router-link :to="path" v-slot="{ href, navigate, isActive, isExactActive }">
    <a class="item" :class="{ active: exact ? isExactActive : isActive }" :href="href" @click="navigate">
      <slot/>
    </a>
  </router-link>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Prop } from 'vue-property-decorator';

  @Component
  export default class NavigationItem extends Vue {
    @Prop() public path!: string;
    @Prop({ default: false }) public exact!: boolean;
  }
</script>

<style scoped lang="scss">
  .item {
    display: flex;
    align-items: center;
    padding: 2rem 1rem;
    color: white;
    text-decoration: none;
    outline: none;
    transition: background-color .25s ease;

    &:hover, &:focus {
      background-color: #2d2d2d;
    }

    &.active {
      padding-bottom: calc(2rem - 3px);
      border-bottom: 3px solid white;
    }
  }
</style>
