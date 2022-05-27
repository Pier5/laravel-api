<template>
  <div v-if="post">
    <h1>Titolo:</h1>
    <h2 class="mb-3">{{ post.title }}</h2>
    <h4>Categoria:</h4>
    <h5 class="mb-4">{{ post.category.type }}</h5>
    <h4>Nome autore:</h4>
    <h5 class="mb-4">{{ post.user.name }}</h5>
    <h4>Tags:</h4>
    <div class="d-flex">
      <div v-for="tag in post.tags" :key="tag.id" class="me-3">
        <h5>{{ tag.name }}</h5>
      </div>
    </div>
  </div>
  
</template>

<script>
export default {
  name: 'PageShow',
  props: ['slug'],
  data() {
    return {
      post: null,
      baseApiUrl: 'http://localhost:8000/api/posts',
    }
  },
  created() {
    this.getData(this.baseApiUrl + '/' + this.slug);
  },
  methods: {
    getData(url) {
      if (url) {
        Axios.get(url)
        .then(res => {
          this.post =  res.data.response.data;
        });
      }
    }
  }
}
</script>

<style>

</style>