<template>
  <div class="center">
    <form class="form" @submit.prevent="submit">
      <Input label="Nummer" v-model="id"/>
      <Input label="Wachtwoord" v-model="password"/>
      <Button type="submit">
        Inloggen
      </Button>
    </form>
  </div>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';

  import Button from '../../components/form/Button.vue';
  import Input from '../../components/form/Input.vue';

  @Component({
    components: {
      Button,
      Input
    }
  })
  export default class Login extends Vue {
    public id = '';
    public password = '';

    public submit() {
      console.log(this.id, this.password);
    }
  }
</script>

<style scoped lang="scss">
  .center {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
  }

  .form {
    padding: 1rem;
    background-color: #262626;
    border-radius: 1rem;
  }
</style>
