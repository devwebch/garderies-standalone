<script>
    import swal from 'sweetalert2';
    import 'sweetalert2/dist/sweetalert2.min.css';

    let data = {};

    export default {
        data() {
            return data;
        },
        mounted() {
            console.log('User show component mounted.');
        },
        methods: {
            deleteUser: function (user) {
                console.log('try to delete');
                if (!user) { return; }
                swal({
                    title: 'Attention !',
                    text: "Vous êtes sur le point de supprimer définitivement cet utilisateur.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/users/' + user)
                        .then(function(response){
                            console.log(response);
                            window.location.replace(response.data.redirect);
                        });
                    }
                });
            }
        }
    }
</script>
