<template>
  <main>
    <Header/>
    <Border>
      <router-view/>
    </Border>
  </main>
</template>

<script>
  import Border from '../components/Border';
  import Header from '../components/Header';

  export default {
    name: 'Public',
    components: {
      Border,
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
