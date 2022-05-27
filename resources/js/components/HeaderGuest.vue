<template>
  <header class="mb-3">
    <router-link class="head-links me-2" :to="{ name: 'home' }" >Home</router-link>
    <router-link class="head-links me-2" :to="{ name: 'articles' }" >Articoli</router-link>
    <router-link class="head-links" :to="{ name: 'about' }" >Su di noi</router-link>
  </header>
</template>

<script>
export default {
  name:'HeaderGuest',
}
</script>

<style lang="scss" scoped>
  .head-links {
    text-decoration: none;
  }
</style>