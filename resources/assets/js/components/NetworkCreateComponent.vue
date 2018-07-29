<script>
    import Swatches from 'vue-swatches';
    import 'vue-swatches/dist/vue-swatches.min.css';

    let data = {
        color: null
    };

    export default {
        props: ['currentColor'],
        data() {
            return data;
        },
        mounted() {
            data.color = this.currentColor;

            $("button[type='submit']").click(function(event) {
                // Fetch form to apply custom Bootstrap validation
                var form = $("form");

                if (form[0].checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.addClass('was-validated');
            });
        },
        components: {
            Swatches
        }
    }
</script>
