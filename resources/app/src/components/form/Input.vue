<template>
  <div class="wrapper">
    <label class="label">
      {{ label }}
    </label>
    <input class="input" @input="onChange"/>
  </div>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Emit, Prop } from 'vue-property-decorator';

  @Component
  export default class Input extends Vue {
    @Prop() public label?: string;

    @Emit('input')
    public onChange(event: InputEvent) {
      return (event.target as HTMLInputElement).value;
    }
  }
</script>

<style scoped lang="scss">
  .wrapper {
    position: relative;
    margin-bottom: .5rem;
  }

  .label {
    position: absolute;
    top: .5rem;
    left: .75rem;
    color: black;
    font-size: .75rem;
    font-weight: bold;
    text-transform: uppercase;
    opacity: .25;
  }

  .input {
    padding: 1.5rem .75rem .5rem .75rem;
    color: black;
    background-color: #f1f1f1;
    border-radius: .5rem;
    outline: none;
    transition: box-shadow .25s ease;

    &:focus {
      box-shadow: 0 0 0 3px darken(#f1f1f1, 25);
    }
  }
</style>
