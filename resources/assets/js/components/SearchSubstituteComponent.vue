<template>
    <div>
        <div class="card card-default mb-4">
            <div class="card-body">
                <form action="#" method="post" v-on:submit.prevent="searchSubstitute">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="day_start">Jour :</label>
                            <flat-pickr
                                    v-model="search.day_start"
                                    :config="flatPickrConfigDays"
                                    class="form-control"
                                    placeholder="Sélectionner une date"
                                    name="day_start">
                            </flat-pickr>
                        </div>
                        <div class="form-group col-6 col-md-3">
                            <label for="hour_start">Heure de début:</label>
                            <flat-pickr
                                    v-model="search.hour_start"
                                    :config="flatPickrConfigHours"
                                    class="form-control"
                                    placeholder="Heure de départ"
                                    name="hour_start">
                            </flat-pickr>
                        </div>
                        <div class="form-group col-6 col-md-3">
                            <label for="hour_end">Heure de fin :</label>
                            <flat-pickr
                                    v-model="search.hour_end"
                                    :config="flatPickrConfigHours"
                                    class="form-control"
                                    placeholder="Heure de fin"
                                    name="hour_end">
                            </flat-pickr>
                        </div>
                        <div class="col" style="/*padding-top: 31px;*/">
                            <label for="">&nbsp;</label>
                            <button class="btn btn-primary btn-block" type="submit">Rechercher</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card card-default">
            <div class="card-header bg-dark text-white">Résultats de recherche</div>
            <div class="card-body">

                <div class="loading-overlay" v-show="!loaded">
                    <div class="sk-folding-cube">
                        <div class="sk-cube1 sk-cube"></div>
                        <div class="sk-cube2 sk-cube"></div>
                        <div class="sk-cube4 sk-cube"></div>
                        <div class="sk-cube3 sk-cube"></div>
                    </div>
                </div>

                <table class="table table-borderless table-striped table-sm table-responsive-sm">
                    <thead v-show="availabilities.length">
                    <tr>
                        <th width="15"><input type="checkbox" v-on:click="selectAll" v-model="peopleSelected"></th>
                        <th>Remplaçant</th>
                        <th>Date</th>
                        <th>Disponibilité</th>
                        <th class="d-none d-md-table-cell"><span data-toggle="tooltip" title="Réseau de travail">Réseaux</span></th>
                        <th class="d-none d-md-table-cell text-right">IC*</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in availabilities">
                        <td><input type="checkbox" v-model="selectedAvailabilities" :value="item"></td>
                        <td>
                            <a v-if="item.user" :href="item.user.link" target="_blank">{{item.user.name}}</a>
                            <span v-if="!item.user" class="text-muted">Aucun</span>
                        </td>
                        <td><i class="fas fa-calendar d-none d-sm-inline"></i> {{item.start}}</td>
                        <td class="text-truncate">{{item.start_hour}} <i class="fas fa-arrow-right"></i>
                            {{item.end_hour}}
                        </td>
                        <td class="d-none d-md-table-cell">
                            <ul class="list-inline m-0">
                                <li v-for="network in item.networks" class="list-inline-item">
                                    <span class="badge badge-info">{{network.name}}</span>
                                </li>
                            </ul>
                            <span v-if="!item.networks" class="text-muted">-</span>
                        </td>
                        <td class="d-none d-md-table-cell text-right">
                            <span class="badge badge-secondary" v-if="item.matching=='none'">{{item.matching}}</span>
                            <span class="badge badge-success" v-if="item.matching=='complete'">Complet</span>
                            <span class="badge badge-warning" v-if="item.matching=='partial'">Partiel</span>
                        </td>
                    </tr>
                    <tr v-if="!availabilities.length">
                        <td colspan="6">
                            <div class="alert alert-info mb-0">Aucune disponibilité</div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p class="text-muted">* Indice de Correspondance (partiel ou complet)</p>
            </div>
            <div class="card-footer d-flex justify-content-end" v-if="selectedAvailabilities.length">
                <button class="btn btn-primary" v-on:click="contactPeopleValidation">Contacter les personnes
                    sélectionnées
                </button>
            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation de contact</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Les personnes sélectionnées seront contactées dans les plus brefs délais afin de confirmer le
                            remplacement de la plage horaire définie, merci de vérifier et compléter les informations ci-dessous :</p>

                        <div class="text-center">
                            <h2>Date : {{search.day_start}}</h2>
                            <p>De {{search.hour_start}} à {{search.hour_end}}</p>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nursery">Etablissement <span class="text-danger">*</span></label>
                                <select name="nursery" class="form-control" v-model="nursery">
                                    <option value="0">Sélectionner...</option>
                                    <option v-for="nursery in nurseries" :value="nursery.id">{{nursery.name}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="workgroup">Groupe de travail <span class="text-danger">*</span></label>
                                <select name="workgroup" class="form-control" v-model="workgroup">
                                    <option value="0">Sélectionner...</option>
                                    <option v-for="workgroup in workgroups" :value="workgroup.id">{{workgroup.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <p class="text-muted">Communiquez à votre remplaçant les informations essentielles.</p>
                            <textarea name="message" cols="30" rows="5" class="form-control" v-model="message"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" :disabled="nursery == 0" v-on:click="contactPeople">Envoyer la demande
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatPickr/dist/flatpickr.css';
    import {French} from 'flatPickr/dist/l10n/fr';

    import swal from 'sweetalert2';
    import 'sweetalert2/dist/sweetalert2.min.css';

    let vm;

    let today = new Date();
    today.setHours(6);
    today.setMinutes(0);

    let later = new Date();
    later.setHours(18);
    later.setMinutes(0);

    let data = {
        flatPickrConfigDays: {
            wrap: true,
            dateFormat: 'd.m.Y',
            locale: French,
            minDate: formattedDate(today)
        },
        flatPickrConfigHours: {
            wrap: true,
            dateFormat: 'H:i',
            enableTime: true,
            noCalendar: true,
            time_24hr: true,
            minuteIncrement: 30,
            locale: French
        },
        peopleSelected: false,
        selectedAvailabilities: [],
        availabilities: {},
        search: {
            day_start: formattedDate(today),
            hour_start: formattedHour(today),
            hour_end: formattedHour(later)
        },
        nurseries: [],
        nursery: 0,
        workgroups: [],
        workgroup: 0,
        message: null,
        loaded: true
    };

    export default {

        data() {
            return data;
        },
        mounted() {
            vm = this;

            this.$nextTick(function () {
                this.searchSubstitute();
            });
        },
        methods: {
            searchSubstitute: function () {
                data.loaded = false;
                data.availabilities = {};

                axios.get('/api/availabilities/search', {
                    params: {
                        'day_start': data.search.day_start,
                        'hour_start': data.search.hour_start,
                        'hour_end': data.search.hour_end,
                    }
                })
                .then(function (response) {
                    data.loaded = true;
                    data.availabilities = response.data.data;
                });
            },
            selectAll: function (event) {
                // Handles the selection of substitutes
                if (data.peopleSelected) {
                    data.selectedAvailabilities = [];
                } else {
                    data.availabilities.forEach(function (item) {
                        data.selectedAvailabilities.push(item);
                    });
                }
            },
            contactPeopleValidation: function () {

                // Retrieve nurseries
                axios.get('/api/nurseries').then(function (response) {
                   data.nurseries = response.data.data;
                });

                // Retrieve workgroups
                axios.get('/api/workgroups').then(function (response) {
                   data.workgroups = response.data;
                });


                $('.modal').modal('show'); // Show the modal
            },
            contactPeople: function () {
                $('.modal').modal('hide'); // Hide the modal

                axios.post('/api/booking-requests', {
                    // Pass the request data to the API
                    availabilities: data.selectedAvailabilities,
                    date_start: data.search.day_start + " " + data.search.hour_start,
                    date_end: data.search.day_start + " " + data.search.hour_end,
                    nursery: data.nursery,
                    workgroup: data.workgroup,
                    message: data.message
                }).then(function (response) {
                    console.log(response);

                    // No error, show an alert
                    swal({
                        title: "Demandes envoyées",
                        text: "Les demandes de remplacements sont en cours d'envoi.",
                        type: "success"
                    }).then((response) => {
                        data.peopleSelected = false;
                        data.selectedAvailabilities = [];
                        data.nursery = 0;
                        data.message = null;
                    });
                });
            }
        },
        components: {
            flatPickr
        }
    }

    // Utils
    function zeroLeadingNumber(num) {
        if (num < 10) {
            return '0' + num;
        }
        return num;
    }

    function formattedHour(date) {
        return zeroLeadingNumber(date.getHours()) + ':' + zeroLeadingNumber(date.getMinutes());
    }

    function formattedDate(date) {
        return zeroLeadingNumber(date.getDate()) + '.' + zeroLeadingNumber(date.getMonth() + 1) + '.' + zeroLeadingNumber(date.getFullYear());
    }

</script>

<style lang="scss">
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(255, 255, 255, 0.75);
        z-index: 10;

        .sk-folding-cube {
            top: 46%;
        }
    }

    .fa-arrow-right {
        font-size: 0.7em;
    }
</style>