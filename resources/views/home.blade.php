@extends('layouts.app')

@section('title', 'Logiciels de gestion de garderie')

@section('content')
    <div class="alert alert-primary alert-guided-tour" style="display: none;">
        Nouvel utilisateur ? Suivez la visite guidée pour découvrir en quoi <em>Garderies</em> peut vous simplifier la gestion de vos structures d'accueil.
        <a href="{{config('app.url')}}/?{{str_random(5)}}#tour">Démarrer la visite</a>
    </div>

    <div class="row mb-4 dashboard__summary">
        <div class="col-md-4 mb-2 mb-sm-0">
            <div class="card card--nurseries card-default">
                <div class="card-body">
                    <div class="widget-count v-step-0">
                        <div class="icon"><i class="fas fa-sitemap"></i></div>
                        <div class="number">{{$count_nursery}}</div>
                        <h3 class="text-muted">Garderies dans votre réseau</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2 mb-sm-0">
            <div class="card card--employees card-default">
                <div class="card-body">
                    <div class="widget-count v-step-1">
                        <div class="icon"><i class="fas fa-users"></i></div>
                        <div class="number">{{$count_user}}</div>
                        <h3 class="text-muted">Nombre d'employés</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2 mb-sm-0">
            <div class="card card--substitutes card-default">
                <div class="card-body">
                    <div class="widget-count v-step-2">
                        <div class="icon"><i class="fas fa-user-clock"></i></div>
                        <div class="number">{{$count_booking}}</div>
                        <h3 class="text-muted">Remplacements ce mois</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card card-default">
                <div class="card-header">Remplacements / disponibilités</div>
                <div class="card-body">
                    <div class="v-step-3" style="height: 400px;">{!! $chartBookings->container() !!}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-default">
                <div class="card-header">Remplacements</div>
                <div class="card-body">
                    <div class="">{!! $topList->topReplacements(7) !!}</div>
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