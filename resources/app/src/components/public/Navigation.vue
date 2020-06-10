<template>
  <td colspan="3">
    <p class="title">
      <img class="logo" src="../../assets/logo.png" alt="Golden Dragon">
      <img class="logo flipped" src="../../assets/logo.png" alt="Golden Dragon">
      <span>Chinees Indische Specialiteiten</span><br>
      <span class="big">De Gouden Draak</span>
    </p>
    <table class="items">
      <tbody>
        <tr>
          <NavigationItem path="/menu">
            Menukaart
          </NavigationItem>
          <NavigationItem path="/nieuws">
            Nieuws
          </NavigationItem>
          <NavigationItem path="/contact">
            Contact
          </NavigationItem>
        </tr>
      </tbody>
    </table>
  </td>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import NavigationItem from './NavigationItem.vue';

  @Component({
    components: {
      NavigationItem
    }
  })
  export default class Navigation extends Vue {}
</script>

<style scoped lang="scss">
  .title {
    margin: 10px 0 20px;
    color: yellow;
    font-size: 40px;
    font-weight: bold;
    text-align: center;

    .big {
      font-size: 50px;
    }
  }

  .logo {
    height: 200px;
    float: left;

    &.flipped {
      float: right;
      transform: scaleX(-1);
    }
  }

  .items {
    margin: auto;
    border: 1px solid grey;
  }
</style>
