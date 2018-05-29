<script>
    import VueTour from 'vue-tour';
    import 'vue-tour/dist/vue-tour.css';

    export default {
        data () {
            return {
                steps: [
                    {
                        target: '.dashboard__summary',
                        content: "Ceci est votre tableau de bord en tant que réseau de garderies."
                    },
                    {
                        target: '.v-step-0',  // We're using document.querySelector() under the hood
                        content: "Gardez un oeil sur tous vos établissements"
                    },
                    {
                        target: '.v-step-1',
                        content: "Gérez vos employées"
                    },
                    {
                        target: '.v-step-2',
                        content: "Surveillez les événements de votre réseau",
                    },
                    {
                        target: '.v-step-3',
                        content: 'Try it, you\'ll love it!<br>You can put HTML in the steps and completely customize the DOM to suit your needs.',
                        params: {
                            placement: 'top'
                        }
                    }
                ]
            }
        },
        mounted: function () {
            this.$tours['myTour'].start()
        },
        components: {VueTour}
    }
</script>

<style lang="scss">
    .v-step {
        z-index: 1;
    }
</style>