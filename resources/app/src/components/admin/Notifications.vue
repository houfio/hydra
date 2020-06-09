<template>
  <transition-group name="notifications" class="notifications" tag="div">
    <button
      :key="notification.id"
      v-for="notification of notifications"
      class="notifications-item"
      @click="remove(notification.id)"
    >
      {{ notification.notification }}
    </button>
  </transition-group>
</template>

<script lang="ts">
  import Vue from 'vue';
  import Component from 'vue-class-component';
  import { Watch } from 'vue-property-decorator';
  import { Mutation, State } from 'vuex-class';

  import { Notification } from '../../types';

  @Component
  export default class Notifications extends Vue {
    @State('notifications', { namespace: 'notification' })
    private notifications!: Notification[];

    @Mutation('remove', { namespace: 'notification' })
    private remove!: (id: string) => void;

    @Watch('notifications')
    public watchNotifications(current: Notification[], previous: Notification[]) {
      for (const { id } of current.filter((c) => !previous.some((p) => c.id === p.id))) {
        setTimeout(() => this.remove(id), 2500);
      }
    }
  }
</script>

<style scoped lang="scss">
  .notifications {
    position: fixed;
    left: 1rem;
    bottom: 1rem;
    z-index: 100;

    &-item {
      display: block;
      width: 15rem;
      margin-top: 1rem;
      padding: 1rem;
      color:  black;
      background-color: white;
      border-radius: .5rem;
      outline: none;
      transition: opacity .25s ease, transform .25s ease;

      &:focus {
        box-shadow: 0 0 0 3px darken(#f1f1f1, 25);
      }
    }

    &-enter, &-leave-to {
      opacity: 0;
    }

    &-leave-active {
      position: absolute;
    }
  }
</style>
