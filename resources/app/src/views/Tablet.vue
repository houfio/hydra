<template>
  <Border :full="true">
    <router-view/>
  </Border>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Border from '../components/Border.vue';

  @Component({
    components: { Border }
  })
  export default class Tablet extends Vue {}
</script>

<style scoped lang="scss">
  @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap');
</style>
