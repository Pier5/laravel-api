<template>
  <div>
    <h1>Benvenuto! inizia a sfogliare i nostri <router-link class="home-links" :to="{ name: 'articles' }">Articoli</router-link>!</h1>
  </div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
  .home-links {
    text-decoration: none;
  }
</style>