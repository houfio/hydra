<template>
  <table>
    <tbody>
      <tr class="spacer">
        <td colspan="9"/>
      </tr>
      <tr class="square">
        <td class="spacer"/>
        <td class="square left top"/>
        <td class="square right top"/>
        <td class="square right"/>
        <td class="top bottom"/>
        <td class="square left"/>
        <td class="square left top"/>
        <td class="square right top"/>
        <td class="spacer"/>
      </tr>
      <tr class="square">
        <td class="spacer"/>
        <td class="square left bottom"/>
        <td class="square top bottom left right"/>
        <td class="square top bottom left right"/>
        <td/>
        <td class="square top bottom left right"/>
        <td class="square top bottom left right"/>
        <td class="square right bottom"/>
        <td class="spacer"/>
      </tr>
      <tr class="square">
        <td class="spacer"/>
        <td class="square bottom"/>
        <td class="square top bottom left right"/>
        <td class="square"/>
        <td/>
        <td class="square"/>
        <td class="square top bottom left right"/>
        <td class="square bottom"/>
        <td class="spacer"/>
      </tr>
      <tr>
        <td class="spacer"/>
        <td class="square left right"/>
        <td class="square"/>
        <td class="square"/>
        <td>
          <slot/>
        </td>
        <td class="square"/>
        <td class="square"/>
        <td class="square left right"/>
        <td class="spacer"/>
      </tr>
      <tr class="square">
        <td class="spacer"/>
        <td class="square top"/>
        <td class="square top bottom left right"/>
        <td class="square"/>
        <td></td>
        <td class="square"/>
        <td class="square top bottom left right"/>
        <td class="square top"/>
        <td class="spacer"/>
      </tr>
      <tr class="square">
        <td class="spacer"/>
        <td class="square left top"/>
        <td class="square top bottom left right"/>
        <td class="square top bottom left right"/>
        <td></td>
        <td class="square top bottom left right"/>
        <td class="square top bottom left right"/>
        <td class="square right top"/>
        <td class="spacer"/>
      </tr>
      <tr class="square">
        <td class="spacer"/>
        <td class="square left bottom"/>
        <td class="square right bottom"/>
        <td class="square right"/>
        <td class="top bottom"/>
        <td class="square left"/>
        <td class="square left bottom"/>
        <td class="square right bottom"/>
        <td class="spacer"/>
      </tr>
      <tr class="spacer">
        <td colspan="9"/>
      </tr>
    </tbody>
  </table>
</template>

<script>
  export default {
    name: 'Border'
  };
</script>

<style scoped lang="scss">
  table {
    width: 100%;
    border-collapse: collapse;
  }

  tr {
    background-color: red;

    &.spacer {
      height: 7px;
    }

    &.square {
      height: 25px;
    }
  }

  td {
    border: 0 solid yellow;

    &.spacer {
      width: 7px;
    }

    &.square {
      width: 25px;
    }

    &.top {
      border-top-width: 4px;
    }

    &.bottom {
      border-bottom-width: 4px;
    }

    &.left {
      border-left-width: 4px;
    }

    &.right {
      border-right-width: 4px;
    }
  }
</style>
