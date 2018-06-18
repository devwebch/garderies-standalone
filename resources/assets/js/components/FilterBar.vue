<template>

      <form class="form-inline float-right">
          <div class="form-group mb-2 mr-sm-2 mb-sm-0">
              <input type="search" v-model="filterText" class="form-control" @keyup.enter="doFilter" placeholder="">
          </div>
          <button class="btn btn-primary" @click.prevent="doFilter">Recherche</button>
      </form>
</template>

<script>
  export default {
    data () {
      return {
        filterText: ''
      }
    },
    methods: {
      doFilter () {
        this.$events.fire('filter-set', this.filterText)
      }
    }
  }
</script>
<style>
.filter-bar {
  padding: 10px;
}
</style>
