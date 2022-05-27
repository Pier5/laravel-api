<template>
  <div v-if="post">
    <h1>{{ post.title }}</h1>
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