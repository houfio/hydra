<template>
  <td>
    <router-link :to="path" v-slot="{ href, navigate }">
      <UglyButton tag="a" :href="href" @click.native="navigate">
        <slot/>
      </UglyButton>
    </router-link>
  </td>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Prop } from 'vue-property-decorator';

  import UglyButton from '../form/UglyButton.vue';

  @Component({
    components: {
      UglyButton
    }
  })
  export default class NavigationItem extends Vue {
    @Prop() public path!: string;
  }
</script>
