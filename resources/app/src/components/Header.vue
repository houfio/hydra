<template>
  <table>
    <tbody>
      <tr>
        <Brand/>
        <td>
          <a href="paginas/aanbiedingen.html" class="offers">
            <marquee behavior="scroll" direction="left">
              Welkom bij De Gouden Draak. Klik op deze tekst om de aanbiedingen van deze week te zien!
            </marquee>
          </a>
        </td>
        <Brand/>
      </tr>
    </tbody>
  </table>
</template>

<script>
  import Brand from './Brand';

  export default {
    name: 'Header',
    components: {
      Brand
    }
  };
</script>

<style scoped lang="scss">
  table {
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
