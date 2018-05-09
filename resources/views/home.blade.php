@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="card card-default dashboard__summary">
        <div class="card-body">
            <div class="row">
                <div class="col widget-count">
                    <h3 style="font-size: 1em">Garderies dans votre réseau</h3>
                    <div class="number" style="font-size: 4em;">12</div>
                    <a href="{{route('nurseries.index')}}">Gérer mes garderies</a>
                </div>
                <div class="col widget-count">
                    <h3 style="font-size: 1em">Nombre d'employés</h3>
                    <div class="number" style="font-size: 4em;">56</div>
                    <a href="{{route('users.index')}}">Gérer mes employés</a>
                </div>
                <div class="col widget-count">
                    <h3 style="font-size: 1em">Remplacements ce mois</h3>
                    <div class="number" style="font-size: 4em;">34</div>
                    <a href="#">Gérer les remplacements</a>
                </div>
            </div>
            <div class="row">
                <div class="col p-4">
                    <img src="{{asset('img/graphs.jpg')}}" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
