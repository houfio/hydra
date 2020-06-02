<template>
  <div class="main">
    <Navigation v-if="navigation"/>
    <router-view/>
  </div>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Navigation from '../components/admin/Navigation.vue';

  @Component({
    components: {
      Navigation
    }
  })
  export default class Admin extends Vue {
    get navigation() {
      return Boolean(this.$route.meta.guard);
    }
  }
</script>

<style scoped lang="scss">
  @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap');

  .main {
    min-height: 100vh;
    color: white;
    background-color: #181818;
    font-family: 'Open Sans', sans-serif;

    & ::-webkit-scrollbar {
      width: 16px;
    }

    & ::-webkit-scrollbar-track {
      background: transparent;
      border-radius: 1rem;
    }

    & ::-webkit-scrollbar-thumb {
      background-color: #444444;
      border: 6px solid #262626;
      border-radius: 0 1rem 1rem 0;
    }
  }
</style>
