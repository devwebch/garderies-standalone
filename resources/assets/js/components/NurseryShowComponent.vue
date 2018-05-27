<script>
    import swal from 'sweetalert2';
    import 'sweetalert2/dist/sweetalert2.min.css';

    let data = {};

    export default {
        data() {
            return data;
        },
        mounted() {
            console.log('Nursery show component mounted.');
        },
        methods: {
            deleteNursery: function (nursery) {
                console.log('try to delete');
                if (!nursery) { return; }
                swal({
                    title: 'Attention !',
                    text: "Vous êtes sur le point de supprimer définitivement cette nursery.",
                    type: 'info',
                    confirmButtonText: 'Cool',
                    showCancelButton: true
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/nurseries/' + nursery)
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
