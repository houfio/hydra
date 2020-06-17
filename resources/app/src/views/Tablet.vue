<template>
  <Border :full="true">
    <Navigation v-if="navigation"/>
    <router-view/>
  </Border>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Border from '../components/Border.vue';
  import Navigation from '../components/tablet/Navigation.vue';

  @Component({
    components: {
      Border,
      Navigation
    }
  })
  export default class Tablet extends Vue {
    public get navigation() {
      return Boolean(this.$route.meta.guard);
    }
  }
</script>

<style scoped lang="scss">
  @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap');
</style>
