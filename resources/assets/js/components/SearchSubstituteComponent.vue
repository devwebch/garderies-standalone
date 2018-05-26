<template>
    <div>
        <div class="card card-default mb-4">
            <div class="card-header">Paramètres de recherche</div>
            <div class="card-body">
                <form action="#" method="post" v-on:submit.prevent="searchSubstitute">
                    <div class="row">
                        <div class="form-group col">
                            <label for="hour_start">Jour :</label>
                            <flat-pickr
                                    v-model="search.day_start"
                                    :config="flatPickrConfigDays"
                                    class="form-control"
                                    placeholder="Sélectionner une date"
                                    name="date">
                            </flat-pickr>
                        </div>
                        <div class="form-group col">
                            <label for="hour_start">Heure de début:</label>
                            <flat-pickr
                                    v-model="search.hour_start"
                                    :config="flatPickrConfigHours"
                                    class="form-control"
                                    placeholder="Heure de départ"
                                    name="date">
                            </flat-pickr>
                        </div>
                        <div class="form-group col">
                            <label for="hour_end">Heure de fin :</label>
                            <flat-pickr
                                    v-model="search.hour_end"
                                    :config="flatPickrConfigHours"
                                    class="form-control"
                                    placeholder="Heure de fin"
                                    name="date">
                            </flat-pickr>
                        </div>
                        <div class="col" style="padding-top: 31px;">
                            <button class="btn btn-primary btn-block" type="submit">Rechercher</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card card-default">
            <div class="card-header">Résultats de recherche</div>
            <div class="card-body">

                <div class="loading-overlay" v-show="!loaded">
                    <div class="sk-folding-cube">
                        <div class="sk-cube1 sk-cube"></div>
                        <div class="sk-cube2 sk-cube"></div>
                        <div class="sk-cube4 sk-cube"></div>
                        <div class="sk-cube3 sk-cube"></div>
                    </div>
                </div>

                <table class="table table-responsive-sm">
                    <thead>
                    <tr>
                        <th width="15"><input type="checkbox" v-on:click="selectAll" v-model="peopleSelected"></th>
                        <th>Nom et prénom</th>
                        <th>Date</th>
                        <th>Disponibilité</th>
                        <th class="d-none d-sm-block">Nursery</th>
                        <th>Correspondance</th>
                    </tr>
                    </thead>
                    <tr v-for="item in availabilities">
                        <td><input type="checkbox" v-model="selectedAvailabilities" :value="item"></td>
                        <td><a :href="item.user.link">{{item.user.name}}</a></td>
                        <td><i class="fas fa-calendar"></i> {{item.start}}</td>
                        <td>{{item.start_hour}} <i class="fas fa-arrow-right"></i> {{item.end_hour}}</td>
                        <td class="d-none d-sm-block"><a :href="item.nursery.link">{{item.nursery.name}}</a></td>
                        <td>
                            <span class="badge badge-secondary" v-if="item.matching=='none'">{{item.matching}}</span>
                            <span class="badge badge-success" v-if="item.matching=='complete'">Complète</span>
                            <span class="badge badge-warning" v-if="item.matching=='partial'">Partielle</span>
                        </td>
                    </tr>
                    <tr v-if="!availabilities.length">
                        <td colspan="6">
                            <div class="alert alert-info mb-0">Aucune disponibilité</div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end" v-if="selectedAvailabilities.length">
                <button class="btn btn-success btn-sm" v-on:click="contactPeopleValidation">Contacter les personnes sélectionnées</button>
            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation de contact</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Les personnes sélectionnées seront contactées dans les plus brefs délais afin de confirmer le remplacement du slot défini, merci de confirmer le remplacement ci-dessous :</p>

                        <div class="text-center">
                            <h2>{{search.day_start}}</h2>
                            <p>De {{search.hour_start}} à {{search.hour_end}}</p>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" v-on:click="contactPeople">Envoyer la demande</button>
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
            locale: French
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
        loaded: true
    };

    export default {

        data() {
            return data;
        },
        mounted() {
            vm = this;

            this.$nextTick(function(){
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
                .then(function(response){
                    console.log(response);
                    data.loaded = true;
                    data.availabilities = response.data.data;
                });
            },
            selectAll: function (event) {
                if (data.peopleSelected) {
                    data.selectedAvailabilities = [];
                } else {
                    data.availabilities.forEach(function(item){
                        data.selectedAvailabilities.push(item);
                    });
                }
            },
            contactPeopleValidation: function () {
                $('.modal').modal('show');
            },
            contactPeople: function () {
                console.log('Contact the people');
                data.peopleSelected = false;
                data.selectedAvailabilities = [];
                $('.modal').modal('hide');

                swal({
                    title: "Demandes envoyées",
                    text: "Les demandes de remplacements sont en cours d'envoi.",
                    type: "success"
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
</style>