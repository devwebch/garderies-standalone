<script>
    import swal from 'sweetalert2';
    import 'sweetalert2/dist/sweetalert2.min.css';

    let data = {
        favorite: false
    };

    export default {
        data() {
            return data;
        },
        props: {
            isFavorite: Number
        },
        mounted() {
            data.favorite = this.isFavorite;
        },
        methods: {
            deleteUser: function (user) {
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
            },
            addToFavorite: function (user) {
                console.log('Add to favorite', user);
                axios.post('/api/users/favorites', {
                    params: {
                        substituteId: user
                    }
                })
                .then(function (response) {
                    let attached = response.data;
                    data.favorite = attached;

                    let message = "Ajouté aux favoris";
                    if (!attached) {
                        message ="Supprimé des favoris";
                    }

                    swal({
                        type: "success",
                        toast: true,
                        title: message,
                        position: "top-right",
                        showConfirmButton: false,
                        timer: 2000
                    });

                });
            }
        }
    }
</script>
