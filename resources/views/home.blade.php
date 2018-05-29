@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="card card-default dashboard__summary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 widget-count v-step-0">
                    <h3 style="font-size: 1em">Garderies dans votre réseau</h3>
                    <div class="number" style="font-size: 4em;">{{$count_nursery}}</div>
                    <a href="{{route('nurseries.index')}}">Gérer mes garderies</a>
                </div>
                <div class="col-md-4 widget-count v-step-1">
                    <h3 style="font-size: 1em">Nombre d'employés</h3>
                    <div class="number" style="font-size: 4em;">{{$count_user}}</div>
                    <a href="{{route('users.index')}}">Gérer mes employés</a>
                </div>
                <div class="col-md-4 widget-count v-step-2">
                    <h3 style="font-size: 1em">Remplacements ce mois</h3>
                    <div class="number" style="font-size: 4em;">{{$count_booking}}</div>
                    <a href="{{route('bookings.index')}}">Gérer les remplacements</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 pt-5">
                    <div class="v-step-3" style="height: 400px;">{!! $chartBookings->container() !!}</div>
                </div>
            </div>
        </div>
    </div>
    <tour inline-template>
        <div>
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
        </div>
    </tour>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js" charset="utf-8"></script>
    {!! $chartBookings->script() !!}
@endsection