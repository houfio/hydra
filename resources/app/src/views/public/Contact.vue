<template>
  <Page>
    <div class="box">
      <span class="message">
        De Gouden Draak is eenvoudig te vinden, vlak bij het centrum,
        5 minuten lopen achter het centraal station.
      </span>
      <p class="message">
        Onderwijsboulevard 215, kamer OG112 <br/>
        5223 DE 's-Hertogenbosch
      </p>
    </div>
    <iframe
        width="800"
        height="600"
        frameborder="0"
        style="border:0"
        src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJ0cXzVYjuxkcRc34iffKXR0w&key=AIzaSyC4HRyQBkle5DUd1bMZFJ7B-KBtY_zAxmQ" allowfullscreen>
    </iframe>
  </Page>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Page from '../../components/public/Page.vue';

  @Component({
    components: {
      Page
    }
  })
  export default class Contact extends Vue {
  }
</script>

<style scoped lang="scss">
  .box {
    padding: 2rem;
    text-align: center;

    .message {
      font-weight: bold;
    }
  }
</style>
