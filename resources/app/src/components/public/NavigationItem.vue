<template>
  <td>
    <router-link :to="path" v-slot="{ href, navigate }">
      <a class="item" :href="href" @click="navigate">
        <slot/>
      </a>
    </router-link>
  </td>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Prop } from 'vue-property-decorator';

  @Component
  export default class NavigationItem extends Vue {
    @Prop() public path!: string;
  }
</script>

<style scoped lang="scss">
  .item {
    display: inline-block;
    width: 130px;
    color: white;
    background-image: linear-gradient(#00f4ff, #0054ff);
    font-size: 20px;
    text-align: center;
    text-decoration: none;
  }
</style>
