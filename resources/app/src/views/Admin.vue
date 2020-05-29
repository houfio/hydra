<template>
  <main class="main">
    <router-view/>
  </main>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  @Component
  export default class Admin extends Vue {}
</script>

<style scoped lang="scss">
  @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap');

  .main {
    min-height: 100vh;
    color: white;
    background-color: #181818;
    font-family: 'Open Sans', sans-serif;
  }
</style>
