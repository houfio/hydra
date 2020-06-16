<template>
  <table class="items">
    <tbody>
      <tr>
        <NavigationItem path="/tablet">
          Menukaart
        </NavigationItem>
        <NavigationItem path="/tablet/bestellen">
          Bestellen ({{ quantity }})
        </NavigationItem>
        <NavigationItem path="/tablet/geschiedenis">
          Geschiedenis
        </NavigationItem>
      </tr>
    </tbody>
  </table>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { State } from 'vuex-class';

  import NavigationItem from '../public/NavigationItem.vue';

  @Component({
    components: {
      NavigationItem
    }
  })
  export default class Navigation extends Vue {
    @State('dishes', { namespace: 'cart' })
    public dishes!: { id: number, quantity: number }[];

    public get quantity() {
      return this.dishes.reduce((previous, current) => previous + current.quantity, 0);
    }
  }
</script>

<style scoped lang="scss">
  .items {
    margin: 0 auto 3rem;
    border: 1px solid grey;
  }
</style>
