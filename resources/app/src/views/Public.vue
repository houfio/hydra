<template>
  <main class="main">
    <Header/>
    <Border>
      <table class="content">
        <tbody>
          <tr>
            <Navigation/>
          </tr>
          <tr class="spacer">
            <td colspan="3"/>
          </tr>
          <tr>
            <td class="spacer"/>
            <router-view/>
            <td class="spacer"/>
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
  .main {
    min-height: 100vh;
    padding: 15px 40px;
    background-color: darkred;
  }

  .content {
    width: 100%;
  }

  tr.spacer {
    height: 50px;
  }

  td.spacer {
    width: 50px;
  }
</style>
