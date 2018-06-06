<script>
    import swal from 'sweetalert2';
    import 'sweetalert2/dist/sweetalert2.min.css';

    let data = {};

    export default {
        data() {
            return data;
        },
        mounted() {
            console.log('Booking show component mounted.');
        },
        methods: {
            validateBooking: function (booking) {
                console.log('validate this shit');
                axios.post('/api/bookings/approve/' + booking)
                    .then(function (response) {
                        console.log(response);

                        swal({
                            title: 'Confirmé',
                            text: "Le remplacement a bien été validé.",
                            type: 'success',
                        }).then((result) => {
                            location.reload();
                        });

                        //window.location.replace(response.data.redirect);
                    });
            },
            deleteBooking: function (booking) {
                console.log('try to delete');
                if (!booking) {
                    return;
                }
                swal({
                    title: 'Attention !',
                    text: "Vous êtes sur le point de supprimer définitivement ce remplacement.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/bookings/' + booking)
                            .then(function (response) {
                                console.log(response);
                                window.location.replace(response.data.redirect);
                            });
                    }
                });
            }
        }
    }
</script>
