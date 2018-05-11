<template>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-default">
                <div class="card-header">Search parameters</div>
                <div class="card-body">
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="date_start">Date start:</label>
                            <input type="datetime-local" class="form-control" name="date_start" v-model="search.date_start">
                        </div>
                        <div class="form-group">
                            <label for="date_end">Date end:</label>
                            <input type="datetime-local" class="form-control" name="date_end" v-model="search.date_end">
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
    let data = {
        substitutes: {},
        search: {
            date_start: 0,
            date_end: 0
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
        }
    }
</script>
