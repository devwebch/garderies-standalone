@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="card card-default dashboard__summary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 widget-count">
                    <h3 style="font-size: 1em">Garderies dans votre réseau</h3>
                    <div class="number" style="font-size: 4em;">{{$count_nursery}}</div>
                    <a href="{{route('nurseries.index')}}">Gérer mes garderies</a>
                </div>
                <div class="col-md-4 widget-count">
                    <h3 style="font-size: 1em">Nombre d'employés</h3>
                    <div class="number" style="font-size: 4em;">{{$count_user}}</div>
                    <a href="{{route('users.index')}}">Gérer mes employés</a>
                </div>
                <div class="col-md-4 widget-count">
                    <h3 style="font-size: 1em">Remplacements ce mois</h3>
                    <div class="number" style="font-size: 4em;">{{$count_booking}}</div>
                    <a href="{{route('bookings.index')}}">Gérer les remplacements</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 pt-5">
                    <div style="height: 300px;">{!! $chart->container() !!}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js" charset="utf-8"></script>
    {!! $chart->script() !!}
@endsection