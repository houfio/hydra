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
          <br/>
          <tr>
            <td colspan="3">
              <router-link to="/contact" v-slot="{ href, navigate }">
                <a class="footer" href="href" @click="navigate">
                  Naar Contact
                </a>
              </router-link>
            </td>
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
    padding: 15px 50px;
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

  .footer {
    display: inline-block;
    width: 100%;
    color: yellow;
    text-align: center;
    text-decoration: none;
  }
</style>
