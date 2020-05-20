<template>
  <router-view/>
</template>

<style lang="scss">
  @font-face {
    font-family: Takeaway;
    src: url('./assets/chinesetakeaway.woff2') format('woff2');
  }

  *, *::before, *:after {
    box-sizing: border-box;
  }

  button {
    text-align: start;

    :hover:not(:disabled) {
      cursor: pointer;
    }
  }

  select, button, input {
    padding: 0;
    background: none;
    border: none;
    font: inherit;
    appearance: none !important;
  }

  h1, h2, h3, h4, h5, h6 {
    margin: 0;
    line-height: 1em;
  }

  img, svg {
    vertical-align: middle;
  }
</style>
