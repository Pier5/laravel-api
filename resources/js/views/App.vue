<template>
  <div class="container">
      <header-guest />
      <router-view />
  </div>
</template>

<script>
import HeaderGuest from '../components/HeaderGuest.vue';
import ContainerCard from  '../components/ContainerCard.vue';
export default {
    name: 'App',
    components: {
        HeaderGuest,
        ContainerCard,
    }
}
</script>

<style>
</style>