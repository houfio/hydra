<template>
  <router-view/>
</template>

<style lang="scss">
  *, *::before, *:after {
    box-sizing: border-box;
  }

  html {
    overflow-y: scroll;
  }

  button {
    text-align: start;

    &:hover:not(:disabled) {
      cursor: pointer;
    }
  }

  select, button, input {
    padding: 0;
    color: inherit;
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
