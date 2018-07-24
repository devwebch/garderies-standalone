<template>
    <div class="card card-default mb-4">
        <div class="card-header bg-dark text-white">
            <div class="row">
                <div class="col-sm-12 col-md-6">{{this.title}}</div>
                <div class="col-sm-12 col-md-6"><filter-bar v-on:filter="setFilter"></filter-bar></div>
            </div>
        </div>
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
                      no-data-template="Aucune donnée disponible">
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
                    <a v-if="props.rowData.user" :href="'/users/' + props.rowData.user.id">{{props.rowData.user.name}}</a>
                    <span v-if="!props.rowData.user" class="text-muted">Aucun</span>
                </template>

                <template slot="substitutelink" slot-scope="props">
                    <a v-if="props.rowData.substitute" :href="'/users/' + props.rowData.substitute.id">{{props.rowData.substitute.name}}</a>
                    <span v-if="!props.rowData.substitute" class="text-muted">Aucun</span>
                </template>

                <template slot="bookinglink" slot-scope="props">
                    <a :href="'/bookings/' + props.rowData.id">{{formatDate(props.rowData.start)}}</a>
                </template>

                <template slot="bookingShowlink" slot-scope="props">
                    <a :href="'/bookings/' + props.rowData.id">Voir</a>
                </template>

                <template slot="ownerlink" slot-scope="props">
                    <a v-if="props.rowData.owner" :href="'/users/' + props.rowData.owner.id">{{props.rowData.owner.name}}</a>
                    <span v-if="!props.rowData.owner" class="text-muted">Aucun</span>
                </template>

                <template slot="networkslinkrelation" slot-scope="props">
                    <ul class="list-inline m-0" v-if="props.rowData.networks">
                        <li class="list-inline-item" v-for="network in props.rowData.networks">
                            <a :href="'/networks/' + network.id">
                                <span class="badge text-white" :style="'background-color: ' + network.color + ';'">{{network.name}}</span>
                            </a>
                        </li>
                    </ul>
                    <span v-if="!props.rowData.networks" class="text-muted">Aucun</span>
                </template>

                <template slot="networklinkrelation" slot-scope="props">
                    <a :href="'/networks/' + props.rowData.network.id" v-if="props.rowData.network">
                        <span class="badge text-white" :style="'background-color: ' + props.rowData.network.color + ';'">
                            {{props.rowData.network.name}}</span>
                    </a>
                    <span v-if="!props.rowData.network" class="text-muted">Aucun</span>
                </template>

                <template slot="nurserylinkrelation" slot-scope="props">
                    <a v-if="props.rowData.nursery" :href="'/nurseries/' + props.rowData.nursery.id">{{props.rowData.nursery.name}}</a>
                    <span v-if="!props.rowData.nursery" class="text-muted">Aucun</span>
                </template>

            </vuetable>
            <div class="vuetable-pagination">
                <vuetable-pagination-info
                        ref="paginationInfo"
                        info-class="pagination-info"
                        info-template="Affichage des données de {from} à {to} sur un total de {total}."
                no-data-template="Aucune donnée disponible"></vuetable-pagination-info>
                <vuetable-pagination-bootstrap ref="pagination" :css="css.pagination" @vuetable-pagination:change-page="onChangePage" :on-each-side="1"></vuetable-pagination-bootstrap>
            </div>
        </div>
    </div>
</template>

<script>
    import accounting from 'accounting'
    import moment from 'moment'
    import Vuetable from 'vuetable-2/src/components/Vuetable'
    import VuetablePaginationBootstrap from './VuetablePaginationBootstrap'
    import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
    import VueTableFilterBar from './VueTableFilterBar'
    import CustomActions from './CustomActions'

    export default {
        props: {
            fields: Array,
            apiUrl:  String,
            title: String,
            statuses: Object
        },
        components: {
            Vuetable,
            VuetablePaginationBootstrap,
            VuetablePaginationInfo,
            'custom-actions': CustomActions,
            'filter-bar': VueTableFilterBar
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
                        pageClass: 'btn btn-sm btn-light',
                        linkClass: 'btn btn-sm btn-light',
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
            setFilter (text) {
                this.moreParams.filter = text;
                Vue.nextTick( () => this.$refs.vuetable.refresh() );
            },
            statusLabel (value) {
                switch (value) {
                    case this.statuses.pending:
                        return '<span class="badge badge-info">En attente</span>';
                    case this.statuses.approved:
                        return '<span class="badge badge-success">Validé</span>';
                    case this.statuses['denied']:
                        return '<span class="badge badge-danger">Refusé</span>';
                    case this.statuses['archived']:
                        return '<span class="badge badge-dark">Archivé</span>';
                }

            },
            formatNumber (value) {
                return accounting.formatNumber(value, 2);
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
                this.$refs.pagination.setPaginationData(paginationData);
                this.$refs.paginationInfo.setPaginationData(paginationData);
            },
            onChangePage (page) {
                this.$refs.vuetable.changePage(page);
            },
        }
    }
</script>

<style lang="scss">
    .vuetable-pagination-info {
        margin-bottom: 20px;
    }
</style>
