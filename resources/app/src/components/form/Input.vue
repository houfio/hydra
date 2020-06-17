<template>
  <div class="wrapper" :class="{ 'has-error': errors && errors.length, spacing: spacing }">
    <label class="label">
      {{ label }}
    </label>
    <select v-if="type === 'select'" class="input" @change="onChange">
      <option v-for="(label, key) in options" :value="key">
        {{ label }}
      </option>
    </select>
    <textarea v-else-if="type === 'textarea'" class="input" :value="value" @input="onChange"/>
    <input v-else class="input" :step="step" :type="type" :value="value" @input="onChange"/>
    <div v-for="error in errors" :key="error" class="error">
      {{ error }}
    </div>
  </div>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Emit, Prop } from 'vue-property-decorator';

  import { FormErrors } from '../../types';

  @Component
  export default class Input extends Vue {
    @Prop() public type?: string;
    @Prop() public label?: string;
    @Prop() public options?: object;
    @Prop() public value?: string;
    @Prop() public step?: string;
    @Prop() public errors?: keyof FormErrors;
    @Prop({ default: true }) public spacing!: boolean;

    @Emit('input')
    public onChange(event: InputEvent) {
      return (event.target as HTMLInputElement).value;
    }
  }
</script>

<style scoped lang="scss">
  .wrapper {
    position: relative;
    border-radius: .5rem;
    font-family: 'Open Sans', sans-serif;
    overflow: hidden;

    &.has-error {
      background-color: #ff0000;
      border-radius: .5rem;
      box-shadow: 0 0 0 3px #ff0000;
    }

    &.spacing {
      margin-bottom: .5rem;
    }
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
    width: 100%;
    padding: 1.5rem .75rem .5rem .75rem;
    color: black;
    background-color: #f1f1f1;
    outline: none;
    vertical-align: top;
    resize: vertical;
    appearance: none;
    transition: box-shadow .25s ease;

    &:focus {
      box-shadow: 0 0 0 3px darken(#f1f1f1, 25);
    }
  }

  .error {
    padding: .25rem .75rem;
  }
</style>
