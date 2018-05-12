<template>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-default">
                <div class="card-header">Search parameters</div>
                <div class="card-body">
                    <form action="#" method="post" v-on:submit.prevent="searchSubstitute">
                        <div class="form-group">
                            <label for="date_start">Date start:</label>
                            <flat-pickr
                                    v-model="search.date_start"
                                    :config="flatPickrConfig"
                                    class="form-control"
                                    placeholder="Select a date"
                                    name="date">
                            </flat-pickr>
                        </div>
                        <div class="form-group">
                            <label for="date_end">Date end:</label>
                            <flat-pickr
                                    v-model="search.date_end"
                                    :config="flatPickrConfig"
                                    class="form-control"
                                    placeholder="Select a date"
                                    name="date">
                            </flat-pickr>
                        </div>

                        <button class="btn btn-primary btn-block" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Search results</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nom et prénom</th>
                            <th>Téléphone</th>
                            <th>E-mail</th>
                            <th>Nursery</th>
                            <th width="50">Actions</th>
                        </tr>
                        </thead>
                        <tr v-for="item in availabilities">
                            <td>{{item.user.name}}</td>
                            <td>{{item.user.phone}}</td>
                            <td><a :href="'mailto:' + item.user.email">{{item.user.email}}</a></td>
                            <td><a :href="item.nursery.link">{{item.nursery.name}}</a></td>
                            <td>
                                <a href="#"><i class="fas fa-phone"></i></a>
                            </td>
                        </tr>
                    </table>
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

    let data = {
        flatPickrConfig: {
            wrap: true,
            dateFormat: 'd.m.Y H:i',
            enableTime: true,
            time_24hr: true,
            minuteIncrement: 30,
            locale: French
        },
        availabilities: {},
        search: {
            date_start: today,
            date_end: today
        }
    };

    export default {

        data() {
            return data;
        },
        mounted() {
            console.log('Component mounted.');

            axios.get('/api/availabilities/search')
                .then(function(response){
                    console.log(response);
                    data.availabilities = response.data.data;
                });
        },
        methods: {
            searchSubstitute: function () {
                console.log('Searching now');
            }
        },
        components: {
            flatPickr
        }
    }
</script>
