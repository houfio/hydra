<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Mutation } from 'vuex-class';

  @Component
  export default class Logout extends Vue {
    @Mutation('setToken', { namespace: 'auth' })
    private setToken!: (token?: string) => void;

    public beforeMount() {
      this.setToken();
      this.$router.push('/');
    }
  }
</script>
