<template>
  <div>

    <div class="row g-4 mb-5">
      <div class="col-3" v-for="post in posts" :key="post.id">
        <div class="card h-100">
          <div class="card-body d-flex flex-column">
            <h4 class="card-title text-uppercase text-center">{{ post.title }}</h4>
            <p class="py-2">{{ post.description }}</p>
            <a :href="'/posts/' + post.slug" class="col-6 align-self-center btn btn-primary mt-auto">Dettagli</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="text-center">Pagina {{ nCurrentPage }} di {{ nLastPage }}</div>
      <nav>
        <ul class="pagination justify-content-center">
          <li class="page-item" :class="{disabled: !prevPageUrl}" @click="getData(prevPageUrl)">
            <a class="page-link">Precedente</a>
          </li>
          <li class="page-item mx-2 align-self-center">
            <form @submit.prevent="getData(baseApiUrl + '/?page=' + nNewPage)">
              <input type="text" name="" id="" v-model="nNewPage">
            </form>
          </li>
          <li class="page-item" :class="{disabled: !nextPageUrl}" @click="getData(nextPageUrl)">
            <a class="page-link">Successiva</a>
          </li>
        </ul>
      </nav>
    </div>

  </div>
</template>

<script>
export default {
  name: 'ContainerCard',
  data() {
    return {
      posts: [],
      baseApiUrl: 'http://localhost:8000/api/posts',
      nNewPage: null,
      prevPageUrl: null,
      nextPageUrl: null,
      nCurrentPage: null,
      nLastPage: null,
      // firstPageUrl: null,
      // lastPageUrl: null,
    }
  },
  created() {
    this.getData(this.baseApiUrl);
  },
  methods: {
    getData(url) {
      if (url) {
        Axios.get(url)
        .then(res => {
          this.posts =  res.data.response.data;
          this.prevPageUrl = res.data.response.prev_page_url;
          this.nextPageUrl = res.data.response.next_page_url;
          this.nCurrentPage = res.data.response.current_page;
          this.nLastPage = res.data.response.last_page;
          this.nNewPage = null;
          // this.firstPageUrl = res.data.response.first_page_url;
          // this.lastPageUrl = res.data.response.last_page_url;
        });
      }
    }
  }
}
</script>

<style>
  .page-link {
    cursor: pointer;
  }
</style>