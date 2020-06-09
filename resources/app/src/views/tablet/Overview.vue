<template>
  <div>
    overview
    <UglyButton>
      Yuck
    </UglyButton>
  </div>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import UglyButton from '../../components/form/UglyButton.vue';

  @Component({
    components: { UglyButton }
  })
  export default class Overview extends Vue {}
</script>
