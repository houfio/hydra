<template>
  <main>
    <Header/>
    <Border>
      <table>
        <tbody>
          <tr>
          </tr>
          <tr>
            <router-view/>
          </tr>
        </tbody>
      </table>
    </Border>
  </main>
</template>

<script>
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Border from '../components/Border';
  import Header from '../components/Header';

  @Component({
    components: {
      Border,
      Header,
    }
  })
  export default class Public extends Vue {}
</script>

<style scoped lang="scss">
  main {
    min-height: 100vh;
    padding: 15px 40px;
    background-color: darkred;
  }
</style>
