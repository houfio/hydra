declare module '*.vue' {
  import Vue from 'vue';

  export default Vue;
}

declare module '*.svg' {
  import Vue from 'vue';

  const value: Vue.VueConstructor<Vue>;

  export default value;
}
