<template>
  <Page>
    <div class="grid">
      <div/>
      <Button @click.native="$router.push('/kassa/types/maken')">
        Aanmaken
      </Button>
      <div class="box big">
        <Loader v-if="loading"/>
        <div v-else v-for="type of types.types" class="dish">
          <div>
            {{ type.name }}
          </div>
          <div>
            <Button @click.native="removeType(type)">
              Verwijderen
            </Button>
          </div>
          <div>
            <Button @click.native="$router.push(`/kassa/types/maken/${type.id}`)">
              Aanpassen
            </Button>
          </div>
        </div>
      </div>
    </div>
  </Page>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Mutation } from 'vuex-class';

  import Page from '../../components/admin/Page.vue';
  import Button from '../../components/form/Button.vue';
  import Loader from '../../components/Loader.vue';
  import { Method } from '../../constants';
  import { DishesApi, DishType } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      Button,
      Loader
    }
  })
  export default class DishTypes extends Vue {
    public types: Partial<DishesApi> = {};

    @Mutation('push', {namespace: 'notification'})
    private push!: (notification: string) => void;

    get loading() {
      return !Object.keys(this.types).length;
    }

    public async mounted() {
      await this.getTypes();
    }

    public async removeType(type: DishType) {
      const deleted = await request(`/types/${type.id}`, Method.Delete);

      if (deleted) {
        await this.getTypes();
        this.push('Product type verwijderd');
      } else {
        this.push('Product type niet verwijderd');
      }
    }

    private async getTypes() {
      const response = await request<DishesApi>('/types', Method.Get);

      if (response.success) {
        this.types = response.data;
      }
    }
  }
</script>

<style scoped lang="scss">
  .grid {
    display: grid;
    grid-template: 3rem calc(100vh - 11rem) / 5fr 1fr;
    grid-gap: 1rem;
  }

  .box {
    padding: 1rem;
    background-color: #262626;
    border-radius: 1rem;

    &.big {
      grid-column: span 2;
      overflow-y: scroll;
    }
  }

  .offer-heading {
    display: flex;
    justify-content: center;
    margin-bottom: 1rem;
    font-size: 2rem;
  }

  .offer {
    display: flex;
    justify-content: flex-start;
    margin-bottom: 1rem;
    font-size: 1.25rem;
  }

  .type {
    display: flex;
    justify-content: center;
    margin-bottom: 1rem;
    font-size: 1.75rem;
  }

  .dish {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;

    & > div:nth-child(1) {
      flex: 1;
    }

    & > div:nth-child(2) {
      width: 8rem;
      margin-right: 1rem;
    }
  }
</style>
