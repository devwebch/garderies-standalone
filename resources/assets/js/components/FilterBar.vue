<template>

      <form class="form-inline float-right">
          <div class="input-group form-group">
              <input type="search" v-model="filterText" class="form-control form-control-sm" aria-describedby="basic-addon2" @keyup.enter="doFilter">
              <div class="input-group-append">
                  <button class="btn btn-sm btn-outline-secondary" type="button" @click.prevent="doFilter"><i class="fa fa-search text-light"></i></button>
              </div>
          </div>
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
