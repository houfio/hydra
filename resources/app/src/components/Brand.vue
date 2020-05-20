<template>
  <td class="brand">
    <img class="logo" src="../assets/logo.png" alt="Golden Dragon"/>
    <span class="name">De Gouden Draak</span>
    <img class="logo flipped" src="../assets/logo.png" alt="Golden Dragon"/>
  </td>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  @Component
  export default class Brand extends Vue {}
</script>

<style scoped lang="scss">
  .brand {
    width: 30%;
    color: yellow;
    font-size: 30px;
    text-align: center;
  }

  .logo {
    height: 50px;

    &.flipped {
      transform: scaleX(-1);
    }
  }

  .name {
    font-family: Takeaway, serif;
  }
</style>
