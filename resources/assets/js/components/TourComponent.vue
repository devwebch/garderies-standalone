<template>
    <v-tour name="myTour" :steps="steps">
        <template slot-scope="tour">
            <transition name="fade">
                <v-step
                        v-if="tour.currentStep === index"
                        v-for="(step, index) of tour.steps"
                        :key="index"
                        :step="step"
                        :previous-step="tour.previousStep"
                        :next-step="tour.nextStep"
                        :stop="tour.stop"
                        :is-first="tour.isFirst"
                        :is-last="tour.isLast"
                >
                    <template>
                        <div slot="actions">
                            <button @click="tour.stop" v-if="!tour.isLast" class="v-step__button">Passer le tour</button>
                            <button @click="tour.previousStep" v-if="!tour.isFirst" class="v-step__button">Précédent</button>
                            <button @click="tour.nextStep" v-if="!tour.isLast" class="v-step__button">Suivant</button>
                            <button @click="tour.stop" v-if="tour.isLast" class="v-step__button">Terminer</button>
                        </div>
                    </template>
                </v-step>
            </transition>
        </template>
    </v-tour>
</template>

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
            if (window.location.hash === '#tour') {
                this.$tours['myTour'].start();
            }
        },
        components: {VueTour}
    }
</script>

<style lang="scss">
    .v-step {
        z-index: 1;
    }
</style>