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
                                    <label for="date_start">Date start:</label>
                                    <flat-pickr
                                            v-model="search.date_start"
                                            :config="flatPickrConfig"
                                            class="form-control"
                                            placeholder="Select a date"
                                            name="date">
                                    </flat-pickr>
                                </div>
                                <div class="form-group col">
                                    <label for="date_end">Date end:</label>
                                    <flat-pickr
                                            v-model="search.date_end"
                                            :config="flatPickrConfig"
                                            class="form-control"
                                            placeholder="Select a date"
                                            name="date">
                                    </flat-pickr>
                                </div>
                                <div class="col" style="padding-top: 31px;">
                                    <button class="btn btn-primary btn-block" type="submit">Search</button>
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
                    <div class="card-body p-0">

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
                                <th width="15"><input type="checkbox" v-on:click="selectAll"></th>
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

                        <div class="selection clearfix" v-if="selectedAvailabilities.length">
                            <a href="#" class="btn btn-primary float-right">Contact the selected people</a>
                        </div>
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
    today.setHours(today.getHours() + 1);
    today.setMinutes(0);

    let otherDay = new Date();
    otherDay.setDate(today.getDate() + 4);
    otherDay.setHours(today.getHours() + 1);
    otherDay.setMinutes(0);

    let data = {
        flatPickrConfig: {
            wrap: true,
            dateFormat: 'd.m.Y H:i',
            enableTime: true,
            time_24hr: true,
            minuteIncrement: 30,
            locale: French
        },
        selectedAvailabilities: [],
        availabilities: {},
        search: {
            date_start: today,
            date_end: otherDay
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
                        'date_start': data.search.date_start,
                        'date_end': data.search.date_end,
                    }
                })
                .then(function(response){
                    console.log(response);
                    data.loaded = true;
                    data.availabilities = response.data.data;
                });
            },
            selectAll: function (event) {
                if (data.selectedAvailabilities.length) {
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