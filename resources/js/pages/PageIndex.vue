<template>
  <div>
    <h1>Sezione Articoli</h1>

    <form @submit.prevent="getData(baseApiUrl + '/posts')" class="row g-3 mb-3">

      <div class="col-md-6">
          <select class="form-select" aria-label="Default select example" name="category" id="category" v-model="filters.category">
              <option value="" selected>Select a category</option>
              <option v-for="category in metadata.categories" :key="category.id" :value="category.id">{{ category.type }}</option>
          </select>
      </div>

      <div class="col-md-6">
          <select class="form-select" aria-label="Default select example" name="author" id="author" v-model="filters.author">
          <option value="" selected>Select an author</option>
          <option v-for="user in metadata.users" :key="user.id" :value="user.id" >{{ user.name }}</option>
          </select>
      </div>

      <div class="col-md-10">
        <label for="search-string" class="form-label">Stringa di ricerca</label>
        <input type="text" class="form-control" id="search-string" name="s" v-model="filters.s">
      </div>

      <div class="col-md-12">
        <fieldset>
          <legend>Tags</legend>
          <div v-for="tag in metadata.tags" :key="tag.id">
            <input type="checkbox" name="tags[]" :id="'tag' + tag.id" :value="tag.name" v-model="filters.tags">
            <label :for="'tag' + tag.id">{{ tag.name }}</label>
          </div>
        </fieldset>
      </div>

      <div class="col-md-2">
        <button class="btn btn-primary">Applica filtri</button>
      </div>
      
    </form>

    <div class="row g-4 mb-5">
      <div class="col-3" v-for="post in posts" :key="post.id">
        <div class="card h-100">
          <div class="card-body d-flex flex-column">
            <h4 class="card-title text-uppercase text-center">{{ post.title }}</h4>
            <p class="py-2">{{ post.description }}</p>
            <router-link :to="{ name: 'details', params: {slug: post.slug} }" class="col-6 align-self-center btn btn-primary mt-auto">Dettagli</router-link>
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
            <form @submit.prevent="getData(baseApiUrl + '/posts/?page=' + nNewPage)">
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
  // name: 'ContainerCard',
  data() {
    return {
      metadata: {},
      posts: [],
      filters: {
        s: '',
        author: '',
        category: '',
        tags: [],
      },
      baseApiUrl: 'http://localhost:8000/api',
      nNewPage: null,
      prevPageUrl: null,
      nextPageUrl: null,
      firstPageUrl: null,
      lastPageUrl: null,
      nCurrentPage: null,
      nLastPage: null,
    }
    },
    created() {
      Axios.get(this.baseApiUrl + '/metadata')
        .then(res => this.metadata = res.data);
      this.getData(this.baseApiUrl + '/posts');
    },
  methods: {
    getData(url) {
    if (url) {
        Axios.get(url, {
            params: this.filters
        })
        .then(res => {
          this.posts =  res.data.response.data;
          this.prevPageUrl = res.data.response.prev_page_url;
          this.nextPageUrl = res.data.response.next_page_url;
          this.firstPageUrl = res.data.response.first_page_url;
          this.lastPageUrl = res.data.response.last_page_url;
          this.nCurrentPage = res.data.response.current_page;
          this.nLastPage = res.data.response.last_page;
          this.nNewPage = null;
        });
      }
    },
  }
}
</script>

<style lang="scss" scoped>
  .page-link {
    cursor: pointer;
  }
</style>