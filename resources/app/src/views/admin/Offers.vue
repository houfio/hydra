<template>
  <Page>
    <div class="grid">
      <div/>
      <Button @click.native="$router.push('/kassa/aanbiedingen/maken')">
        Aanmaken
      </Button>
      <div class="box big">
        <div v-for="offer of offers" class="offer">
          <div v-if="offer.valid_until">
            {{ offer.valid_until }}
          </div>
          <div v-else>
            Geen einddatum
          </div>
          <div>
            {{ offer.name }}
          </div>
          <div>
            &euro;{{ offer.price.toFixed(2) }}
          </div>
          <div>
            <Button @click.native="remove(offer)">
              Verwijderen
            </Button>
          </div>
          <div>
            <Button @click.native="$router.push(`/kassa/aanbiedingen/maken/${offer.id}`)">
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
  import { Method } from '../../constants';
  import { Offer, OffersApi } from '../../types';
  import { request } from '../../utils/request';

  @Component({
    components: {
      Page,
      Button
    }
  })
  export default class Offers extends Vue {
    public offers: Offer[] = [];

    @Mutation('push', {namespace: 'notification'})
    private push!: (notification: string) => void;

    public async mounted() {
      await this.getOffers();
    }

    public async remove(offer: Offer) {
      const deleted = await request(`/offers/${offer.id}`, Method.Delete);

      if (deleted) {
        this.push('Aanbieding verwijderd');
        await this.getOffers();
      } else {
        this.push('Aanbieding niet verwijderd');
      }
    }

    private async getOffers() {
      const response = await request<OffersApi>('/offers', Method.Get);

      if (response.success) {
        this.offers = response.data.offers;
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

  .offer {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;

    & > div:nth-child(1) {
      width: 12.5rem;
    }

    & > div:nth-child(2) {
      flex: 1;
    }

    & > div:nth-child(3) {
      margin-right: 1rem;
    }

    &:last-child {
      margin-bottom: 2rem;
    }
  }
</style>
