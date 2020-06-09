<template>
  <nav class="navigation">
    <NavigationItem path="/kassa">
      Kassa
    </NavigationItem>
    <NavigationItem path="/kassa/gerechten">
      Gerechten
    </NavigationItem>
    <NavigationItem path="/kassa/bestellingen">
      Bestellingen
    </NavigationItem>
    <NavigationItem path="/kassa/aanbiedingen">
      Aanbiedingen
    </NavigationItem>
    <NavigationItem path="/kassa/verkopen">
      Verkopen
    </NavigationItem>
    <div class="spacer"/>
    <NavigationItem path="/kassa/logout">
      Uitloggen
    </NavigationItem>
  </nav>
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
  .navigation {
    display: flex;
    height: 4rem;
    background-color: #262626;
  }

  .spacer {
    flex: 1;
  }
</style>
