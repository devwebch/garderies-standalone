<template>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-default">
                <div class="card-header">Search parameters</div>
                <div class="card-body">
                    <form action="#" method="post">
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
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Search substitute</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Téléphone</th>
                            <th width="50">Actions</th>
                        </tr>
                        </thead>
                        <tr>
                            <td>Lorem</td>
                            <td>Ipsum</td>
                            <td>+41 79 474 42 37</td>
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
        substitutes: {},
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

            /*axios.get('/api/nurseries')
                .then(function(response){
                    console.log(response);
                    data.nurseries = response.data.data;
                });*/
        },
        components: {
            flatPickr
        }
    }
</script>
