<template>
  <Page>
    <span class="head-heading">De Gouden Draak menukaart</span>
    <div v-for="type in response.types">
      <span class="type-heading">
        {{ type.name }}
      </span>
      <ul class="menu">
        <li class="menu-item" v-for="dish in type.dishes">
          <div class="section">
            <div class="heading">
              <span class="title">{{ dish.number }}. {{ dish.name }}
                <button @click="favorite(dish.id)" :style="favorited(dish.id) ? 'color: red' : 'color: green'">
                  Fav
                </button>
              </span>
              <span class="spacer"></span>
              <span class="price">&euro;{{ dish.price.toFixed(2) }}</span>
            </div>
            <p v-if="dish.description">
              ({{ dish.description }})
            </p>
          </div>
        </li>
      </ul>
    </div>
    <span class="head-heading">Aanbiedingen</span>
    <div v-for="offer in response.offers">
      <span class="type-heading">
        {{ offer.name }} &euro;{{ offer.price.toFixed(2) }}
      </span>
      <ul class="menu">
        <li class="menu-item" v-for="dish in offer.dishes">
          <div class="section">
            <div class="heading">
              <span class="title">{{ dish.number }}. {{ dish.name }}</span>
            </div>
            <p v-if="dish.description">
              ({{ dish.description }})
            </p>
          </div>
        </li>
      </ul>
    </div>
  </Page>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Button from '../../components/form/Button.vue';
  import Page from '../../components/public/Page.vue';
  import { Method } from '../../constants';
  import { MenuApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      Button
    }
  })
  export default class Menu extends Vue {
    public response: Partial<MenuApi> = {};
    public favorites: number[] = JSON.parse(this.$cookies.get('favorites') || '[]');

    public async mounted() {
      const response = await request<MenuApi>('/menu', Method.Get);

      if (response.success) {
        this.response = response.data;
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
  .head-heading {
    display: block;
    text-align: center;
    font-weight: bold;
    font-size: 35px;
    margin-top: 1rem;
  }
  .type-heading {
    font-weight: bold;
    font-size: 25px;
    text-align: center;
    display: block;
    margin: 2rem 0;
  }
  .menu {
    display: flex;
    list-style-type: none;
    flex-wrap: wrap;
    padding: 0;
    margin: 0 auto;
    max-width: 960px;
    height: 100%;
    .menu-item {
      display: flex;
      width: 50%;
      list-style-type: none;
      padding: 0 1rem;
      margin: 0 0 1rem;
      .section {
        display: flex;
        flex-direction: column;
        flex: 1;
        .heading {
          display: flex;
          width: 100%;
          justify-content: center;
          align-items: center;
          .spacer {
            content: '';
            width: 100%;
            height: 1px;
            margin: 0 .5rem;
            border-bottom: 1px dashed black;
            flex: 1;
          }
          .title {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
          }
        }
      }
    }
  }
</style>
