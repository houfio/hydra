<template>
  <Page padding="2rem 1rem">
    <h1 class="center">De Gouden Draak menukaart</h1>
    <div class="center">
      <UglyButton tag="a" :href="url" download :disabled="!url" target="_blank">
        Download
      </UglyButton>
    </div>
    <MenuComponent :response="response" :icon="heart" :active="favorited" @toggle="favorite"/>
  </Page>
</template>

<script lang="ts">
  import { faHeart } from '@fortawesome/free-solid-svg-icons';
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Button from '../../components/form/Button.vue';
  import UglyButton from '../../components/form/UglyButton.vue';
  import MenuComponent from '../../components/Menu.vue';
  import Page from '../../components/Page.vue';
  import { Method } from '../../constants';
  import { MenuApi, MenuDownloadApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      FontAwesomeIcon,
      Button,
      UglyButton,
      MenuComponent,
      Page
    }
  })
  export default class Menu extends Vue {
    public response: Partial<MenuApi> = {};
    public url = '';
    public favorites: number[] = JSON.parse(this.$cookies.get('favorites') || '[]');

    public get heart() {
      return faHeart;
    }

    public async mounted() {
      const response = await request<MenuApi>('/menu', Method.Get);

      if (response.success) {
        this.response = response.data;
      }

      const downloadResponse = await request<MenuDownloadApi>('/menu/current', Method.Get);

      if (downloadResponse.success) {
        this.url = downloadResponse.data.url;
      }
    }

    public favorited(id: number) {
      return this.favorites.indexOf(id) !== -1;
    }

    public favorite(id: number) {
      const current = this.favorited(id);

      this.favorites = [
        ...this.favorites.filter((f) => f !== id),
        ...current ? [] : [id]
      ];

      this.$cookies.set('favorites', JSON.stringify(this.favorites), -1);
    }
  }
</script>

<style scoped lang="scss">
  .center {
    text-align: center;
  }

  .type {
    margin: 2rem 0;
  }

  .menu {
    display: flex;
    flex-wrap: wrap;

    &-item {
      flex: 0 0 50%;
      padding: 1rem;
    }

    &-header {
      display: flex;
      align-items: center;
    }
  }

  .action {
    margin-right: 1rem;

    &.active {
      color: green;
    }
  }

  .spacer {
    flex: 1;
    height: 1px;
    margin: 0 .5rem;
    border-bottom: 1px dashed black;
  }
</style>
