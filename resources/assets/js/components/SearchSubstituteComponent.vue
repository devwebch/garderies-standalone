<template>
    <div>
        <div class="row mb-4">
            <div class="col">
                <div class="card card-default">
                    <div class="card-header">Search parameters</div>
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
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card card-default">
                    <div class="card-header">Search results</div>
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
                                <th width="15"><input type="checkbox" v-on:click="selectAll" v-model="selected"></th>
                                <th>Nom et prénom</th>
                                <th>Date</th>
                                <th>Hours</th>
                                <th class="d-none d-sm-block">Nursery</th>
                                <th width="50">Actions</th>
                            </tr>
                            </thead>
                            <tr v-for="item in availabilities">
                                <td><input type="checkbox" v-model="selectedAvailabilities" :value="item"></td>
                                <td><a :href="item.user.link">{{item.user.name}}</a></td>
                                <td><i class="fas fa-calendar"></i> {{item.start}}</td>
                                <td>{{item.start_hour}} <i class="fas fa-arrow-right"></i> {{item.end_hour}}</td>
                                <td class="d-none d-sm-block"><a :href="item.nursery.link">{{item.nursery.name}}</a></td>
                                <td>
                                    <a :href="'tel:' + item.user.phone"><i class="fas fa-phone"></i></a>
                                    <a :href="'mailto:' + item.user.email"><i class="fas fa-envelope"></i></a>
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
                        <a href="#" class="btn btn-success btn-sm">Contact the selected people</a>
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

    let today = new Date();
    today.setDate(today.getDate() + 1);
    today.setHours(today.getHours() + 1);
    today.setMinutes(0);

    let todayButAfter = new Date();
    todayButAfter.setDate(today.getDate());
    todayButAfter.setHours(today.getHours() + 4);
    todayButAfter.setMinutes(0);

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
        selected: false,
        selectedAvailabilities: [],
        availabilities: {},
        search: {
            day_start: today,
            hour_start: today,
            hour_end: todayButAfter
        },
        loaded: false
    };

    export default {

        data() {
            return data;
        },
        mounted() {
            this.searchSubstitute();
        },
        methods: {
            searchSubstitute: function () {
                data.loaded = false;
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
                if (data.selected) {
                    data.selectedAvailabilities = [];
                } else {
                    data.availabilities.forEach(function(item){
                        data.selectedAvailabilities.push(item);
                    });
                }
            }
        },
        components: {
            flatPickr
        }
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