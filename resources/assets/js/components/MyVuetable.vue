<template>
    <div class="card card-default mb-4">
        <div class="card-header bg-dark text-white"><div class="row"><div class="col-sm-12 col-md-6">{{this.title}}</div><div class="col-sm-12 col-md-6"><filter-bar></filter-bar></div></div></div>
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
                      no-data-template="Aucune donnée disponible"
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

                <template slot="userbookinglink" slot-scope="props">
                    <a :href="'/users/' + props.rowData.user_id">{{props.rowData.user_name}}</a>
                </template>

                <template slot="substitutelink" slot-scope="props">
                    <a :href="'/users/' + props.rowData.substitute_id">{{props.rowData.substitute_name}}</a>
                </template>

                <template slot="bookinglink" slot-scope="props">
                    <a :href="'/bookings/' + props.rowData.id">{{formatDate(props.rowData.start)}}</a>
                </template>

                <template slot="ownerlink" slot-scope="props">
                    <a :href="'/users/' + props.rowData.owner.id">{{props.rowData.owner.name}}</a>
                </template>

                <template slot="networkslinkrelation" slot-scope="props">
                    <a :href="'/networks/' + props.rowData.networks_id">{{props.rowData.network_name}}</a>
                </template>

                <template slot="networklinkrelation" slot-scope="props" v-if="props.rowData.network">
                    <a :href="'/networks/' + props.rowData.network_id">
                        {{props.rowData.network.name}}
                    </a>
                </template>

                <template slot="nurserylinkrelation" slot-scope="props">
                    <a :href="'/nurseries/' + props.rowData.nursery_id">{{props.rowData.nursery_name}}</a>
                </template>

            </vuetable>
            <div class="vuetable-pagination">
                <vuetable-pagination-info ref="paginationInfo" info-class="pagination-info" info-template="Affichage des données de {from} à {to} sur un total de {total}."></vuetable-pagination-info>
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
            },
            statuses: {
                type: Object
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
                        tableClass: 'table table-borderless table-striped table-responsive-xs',
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
        mounted() {},
        methods: {
            allcap (value) {
                return value.toUpperCase()
            },
            statusLabel (value) {
                console.log(this.statuses['approved']);
                switch (value) {
                    case this.statuses['pending']:
                        return '<span class="badge badge-info">En attente</span>'
                    case this.statuses['approved']:
                        return '<span class="badge badge-success">Validé</span>'
                    case this.statuses['archived']:
                        return '<span class="badge badge-dark">Archivé</span>'
                }

            },
            formatNumber (value) {
                return accounting.formatNumber(value, 2)
            },
            formatDate (value, fmt = 'DD.MM.YYYY') {
                return (value == null)
                    ? ''
                    : moment(value, 'YYYY-MM-DD').format(fmt)
            },
            formatTime (value, fmt = 'HH:mm') {
                return (value == null)
                    ? ''
                    : moment(value, 'YYYY-MM-DD HH:mm:ss').format(fmt)
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
                };
                Vue.nextTick( () => this.$refs.vuetable.refresh() )
            },
            'filter-reset' () {
                this.moreParams = {};
                Vue.nextTick( () => this.$refs.vuetable.refresh() )
            }
        }
    }
</script>

