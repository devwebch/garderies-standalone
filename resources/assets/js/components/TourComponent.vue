<script>
    import Vue from 'vue'
    import VueTour from 'vue-tour'

    require('vue-tour/dist/vue-tour.css')

    Vue.use(VueTour)

    export default {
        name: "TourComponent",
        data () {
            return {
                steps: [
                    {
                        target: '#v-step-0',  // We're using document.querySelector() under the hood
                        content: `Discover <strong>Vue Tour</strong>!`
                    },
                    {
                        target: '.v-step-1',
                        content: 'An awesome plugin made with Vue.js!'
                    },
                    {
                        target: '[data-v-step="2"]',
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
        }
    }
</script>

<style scoped>

</style>