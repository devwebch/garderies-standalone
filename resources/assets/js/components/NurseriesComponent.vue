<template>
    <div class="card card-default">
        <div class="card-header">Etablissements</div>
        <div class="card-body p-0">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Employés</th>
                        <th>Remplacements</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="nursery in nurseries" :key="nursery.id">
                        <td><a :href="nursery.link">{{nursery.name}}</a></td>
                        <td>{{nursery.employees_count}}</td>
                        <td>{{nursery.bookings_count}}</td>
                        <td><a :href="nursery.link"><i class="fas fa-eye"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    let data = {
        nurseries: {}
    };

    export default {

        data() {
            return data;
        },
        mounted() {
            console.log('Component mounted.');

            axios.get('/api/nurseries')
                .then(function(response){
                    console.log(response);
                    data.nurseries = response.data.data;
                });
        }
    }
</script>
