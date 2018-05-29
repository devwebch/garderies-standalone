<template>
    <div class="card card-default mb-4">
        <div class="card-header">Employés</div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>Nom et prénom</th>
                    <th>Téléphone</th>
                    <th>E-mail</th>
                    <th v-if="!nursery">Nursery</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users">
                    <td><a :href="user.link">{{user.name}}</a></td>
                    <td>{{user.phone}}</td>
                    <td>{{user.email}}</td>
                    <td v-if="!nursery">{{user.nursery}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>

    //TODO: add prop for nursery, restrict listing to a single parent

    let data = {
        users: {}
    };

    export default {

        data() {
            return data;
        },
        props: {
            nursery: {
                type: Number,
                default: 0
            }
        },
        mounted() {
            console.log('Component mounted.');

            axios.get('/api/users', {
                params: {
                    nursery: this.nursery
                }
            })
            .then(function (response) {
                console.log(response);
                data.users = response.data;
            });
        }
    }
</script>
