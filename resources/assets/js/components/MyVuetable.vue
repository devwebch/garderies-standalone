<template>
    <div class="card card-default">
        <div class="card-header bg-dark text-white"><div class="row"><div class="col-md-6">{{this.title}}</div><div class="col-md-6"><filter-bar></filter-bar></div></div></div>
        <div class="card-body">
            <vuetable ref="vuetable"
                      :api-url="this.apiUrl"
                      :fields="this.fields"
                      pagination-path=""
                      :css="css.table"
                      :multi-sort="true"
                      detail-row-component="my-detail-row"
                      :append-params="moreParams"
                      @vuetable:pagination-data="onPaginationData"
            >
                <template slot="nurserylink" slot-scope="props">
                    <a :href="'/nurseries/' + props.rowData.id">{{props.rowData.name}}</a>
                </template>

                <template slot="networklink" slot-scope="props">
                    <a :href="'/networks/' + props.rowData.id">{{props.rowData.name}}</a>
                </template>

                <template slot="userlink" slot-scope="props">
                    <a :href="'/users/' + props.rowData.id">{{props.rowData.name}}</a>
                </template>

                <template slot="ownerlink" slot-scope="props">
                    <a :href="'/users/' + props.rowData.owner.id">{{props.rowData.owner.name}}</a>
                </template>

                <template slot="networklinkrelation" slot-scope="props">
                    <a :href="'/networks/' + props.rowData.networks_id">{{props.rowData.network_name}}</a>
                </template>

                <template slot="nurserylinkrelation" slot-scope="props">
                    <a :href="'/nurseries/' + props.rowData.nursery_id">{{props.rowData.nursery_name}}</a>
                </template>

                <template slot="ownerlink" slot-scope="props">
                    <a :href="'/users/' + props.rowData.owner.id">{{props.rowData.owner.name}}</a>
                </template>

            </vuetable>
            <div class="vuetable-pagination">
                <vuetable-pagination-info ref="paginationInfo"
                                          info-class="pagination-info"
                ></vuetable-pagination-info>
                <vuetable-pagination ref="pagination"
                                     :css="css.pagination"
                                     @vuetable-pagination:change-page="onChangePage"
                ></vuetable-pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import accounting from 'accounting'
    import moment from 'moment'
    import Vuetable from 'vuetable-2/src/components/Vuetable'
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
    import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
    import Vue from 'vue'
    import VueEvents from 'vue-events'
    import CustomActions from './CustomActions'
    import FilterBar from './FilterBar'

    Vue.use(VueEvents)
    Vue.component('custom-actions', CustomActions)
    Vue.component('filter-bar', FilterBar)

    export default {
        props: {
            fields: {
                type: Array
            },
            apiUrl: {
                type: String
            },
            title: {
                type: String
            }
        },
        components: {
            Vuetable,
            VuetablePagination,
            VuetablePaginationInfo,
        },
        data () {
            return {
                css: {
                    table: {
                        tableClass: 'table table-borderless table-striped table-responsive-lg',
                        ascendingIcon: 'fa fa-chevron-up',
                        descendingIcon: 'fa fa-chevron-down'
                    },
                    pagination: {
                        wrapperClass: 'pagination',
                        activeClass: 'active',
                        disabledClass: 'disabled',
                        pageClass: 'page',
                        linkClass: 'link',
                        icons: {
                            first: 'fa fa-step-backward',
                            prev: 'fa fa-chevron-left',
                            next: 'fa fa-chevron-right',
                            last: 'fa fa-step-forward',
                        },
                    },
                    icons: {
                        first: 'glyphicon glyphicon-step-backward',
                        prev: 'fa fa-chevron-left',
                        next: 'fa fa-chevron-right',
                        last: 'glyphicon glyphicon-step-forward',
                    },
                },
                moreParams: {}
            }
        },
        methods: {
            allcap (value) {
                return value.toUpperCase()
            },
            genderLabel (value) {
                return value === 'M'
                    ? '<span class="label label-success"><i class="glyphicon glyphicon-star"></i> Male</span>'
                    : '<span class="label label-danger"><i class="glyphicon glyphicon-heart"></i> Female</span>'
            },
            formatNumber (value) {
                return accounting.formatNumber(value, 2)
            },
            formatDate (value, fmt = 'D MMM YYYY') {
                return (value == null)
                    ? ''
                    : moment(value, 'YYYY-MM-DD').format(fmt)
            },
            onPaginationData (paginationData) {
                this.$refs.pagination.setPaginationData(paginationData)
                this.$refs.paginationInfo.setPaginationData(paginationData)
            },
            onChangePage (page) {
                this.$refs.vuetable.changePage(page)
            },
        },
        events: {
            'filter-set' (filterText) {
                this.moreParams = {
                    filter: filterText
                }
                Vue.nextTick( () => this.$refs.vuetable.refresh() )
            },
            'filter-reset' () {
                this.moreParams = {}
                Vue.nextTick( () => this.$refs.vuetable.refresh() )
            }
        }
    }
</script>

