<template>
  <main>
    <Header/>
    public
    <router-view/>
  </main>
</template>

<script>
  import Header from '../components/Header';

  export default {
    name: 'Public',
    components: {
      Header
    }
  };
</script>

<style scoped lang="scss">
  main {
    min-height: 100vh;
    padding: 15px 40px;
    background-color: darkred;
  }
</style>
