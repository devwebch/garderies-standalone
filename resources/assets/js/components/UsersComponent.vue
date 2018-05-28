<template>
    <div class="card card-default">
        <div class="card-header">Utilisateurs</div>
        <div class="card-body p-0">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom et prénom</th>
                        <th>Téléphone</th>
                        <th>Nursery</th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users">
                        <td><a :href="user.link">{{user.name}}</a></td>
                        <td>{{user.phone}}</td>
                        <td>{{user.nursery}}</td>
                        <td>
                            <a href="#"><i class="fas fa-phone"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    let data = {
        users: {}
    };

    export default {

        data() {
            return data;
        },
        mounted() {
            console.log('Component mounted.');

            axios.get('/api/users')
                .then(function(response){
                    data.users = response.data.data;
                });
        }
    }
</script>
