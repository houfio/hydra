<template>
  <div class="paginator">
    <Button :disabled="!paginated.prev_page_url" @click.native="backward">
      <
    </Button>
    <span class="page">
      {{ paginated.current_page }}
    </span>
    <Button :disabled="!paginated.next_page_url" @click.native="forward">
      >
    </Button>
  </div>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Prop } from 'vue-property-decorator';

  import { Paginated } from '../types';

  import Button from './form/Button.vue';

  @Component({
    components: {
      Button
    }
  })
  export default class Paginator extends Vue {
    @Prop() public paginated!: Paginated<any>;

    public backward() {
      this.$emit('paginate', this.paginated.current_page - 1);
    }

    public forward() {
      this.$emit('paginate', this.paginated.current_page + 1);
    }
  }
</script>

<style scoped lang="scss">
  .paginator {
    display: flex;
    align-items: center;
  }

  .page {
    padding: 0 .5rem;
  }
</style>
