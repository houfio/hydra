<template>
  <table class="header">
    <tbody>
      <tr>
        <Brand/>
        <td>
          <router-link to="/offers" v-slot="{ href, navigate }">
            <a class="offers" :href="href" @click="navigate">
              <marquee behavior="scroll" direction="left">
                Welkom bij De Gouden Draak. Klik op deze tekst om de aanbiedingen van deze week te zien!
              </marquee>
            </a>
          </router-link>
        </td>
        <Brand/>
      </tr>
    </tbody>
  </table>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Brand from './Brand.vue';

  @Component({
    components: {
      Brand
    }
  })
  export default class Header extends Vue {}
</script>

<style scoped lang="scss">
  .header {
    width: 100%;
    border-collapse: collapse;
  }

  tr {
    height: 50px;
    background-color: red;
  }

  .offers {
    color: yellow;
    font-weight: bold;
    text-decoration: none;
  }
</style>
