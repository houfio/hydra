<template>
  <div>
    <div v-for="type in response.types">
      <h2 class="type center">
        {{ type.name }}
      </h2>
      <div class="menu">
        <div v-for="dish in type.dishes" class="menu-item">
          <div class="menu-header">
            <button
                v-if="icon"
                class="action"
                :class="{ active: active && active(dish.id) }"
                @click="$emit('toggle', dish.id)"
            >
              <FontAwesomeIcon :icon="icon"/>
            </button>
            <h3>{{ dish.number }}. {{ dish.name }}</h3>
            <span class="spacer"/>
            <span>&euro;{{ dish.price.toFixed(2) }}</span>
          </div>
          <p v-if="dish.description">
            ({{ dish.description }})
          </p>
        </div>
      </div>
    </div>
    <div v-for="offer in response.offers">
      <h2 class="type center">
        <button
            v-if="icon"
            class="action"
            :class="{ active: active && active(offer.id) }"
            @click="$emit('toggle', offer.id)"
        >
          <FontAwesomeIcon :icon="icon"/>
        </button>
        {{ offer.name }} &euro;{{ offer.price.toFixed(2) }}
      </h2>
      <div class="menu">
        <div v-for="dish in offer.dishes" class="menu-item">
          <div class="menu-header">
            <h3>{{ dish.number }}. {{ dish.name }}</h3>
            <span class="spacer"/>
          </div>
          <p v-if="dish.description">
            ({{ dish.description }})
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
  import { IconDefinition } from '@fortawesome/free-solid-svg-icons';
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Prop } from 'vue-property-decorator';

  import { MenuApi } from '../types';

  @Component({
    components: {
      FontAwesomeIcon
    }
  })
  export default class Menu extends Vue {
    @Prop({default: () => ({})}) public response!: Partial<MenuApi>;
    @Prop() public active?: (id: number) => boolean;
    @Prop() public icon?: IconDefinition;
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
