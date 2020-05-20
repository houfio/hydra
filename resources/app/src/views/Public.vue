<template>
  <main>
    <Header/>
    <Border>
      <table>
        <tbody>
          <tr>
            <Navigation/>
          </tr>
          <tr>
            <router-view/>
          </tr>
        </tbody>
      </table>
    </Border>
  </main>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Border from '../components/Border.vue';
  import Header from '../components/Header.vue';
  import Navigation from '../components/Navigation.vue';

  @Component({
    components: {
      Border,
      Header,
      Navigation
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
