<template>
  <div>
    admin
    <router-view/>
  </div>
</template>

<script>
  import Vue from 'vue';
  import Component from 'vue-class-component';

  @Component
  export default class Admin extends Vue {}
</script>
