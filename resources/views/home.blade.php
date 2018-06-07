@extends('layouts.app')

@section('title', 'Logiciels de gestion de garderie')

@section('content')
    <div class="alert alert-primary alert-guided-tour">
        Nouvel utilisateur ? Suivez la visite guidée pour découvrir en quoi <em>Garderies</em> peut vous simplifier la gestion de vos structures d'accueil.
        <a href="{{config('app.url')}}/?{{str_random(5)}}#tour">Démarrer la visite</a>
    </div>

    <div class="row mb-4 dashboard__summary">
        <div class="col-md-4">
            <div class="card card-default">
                <div class="card-body">
                    <div class="widget-count v-step-0">
                        <h3>Garderies dans votre réseau</h3>
                        <div class="number">{{$count_nursery}}</div>
                        <a href="{{route('nurseries.index')}}">Gérer les garderies</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-default">
                <div class="card-body">
                    <div class="widget-count v-step-1">
                        <h3>Nombre d'employés</h3>
                        <div class="number">{{$count_user}}</div>
                        <a href="{{route('users.index')}}">Gérer les employés</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-default">
                <div class="card-body">
                    <div class="widget-count v-step-2">
                        <h3>Remplacements ce mois</h3>
                        <div class="number">{{$count_booking}}</div>
                        <a href="{{route('bookings.index')}}">Gérer les remplacements</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-body">
                    <div class="v-step-3" style="height: 400px;">{!! $chartBookings->container() !!}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-body">
                    <div class="">{!! $topList->listOne() !!}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('hook-vue')
    <tour></tour>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js" charset="utf-8"></script>
    {!! $chartBookings->script() !!}
@endsection