@extends('layouts.two-columns')

@section('title', 'Réseaux')

@section('content')
    <h1>Réseaux</h1>

    <div class="card card-default">
        <div class="card-header">Réseaux</div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Employés</th>
                    <th>Administrateur</th>
                </tr>
                </thead>
                <tbody>
                @foreach($networks as $network)
                    <tr>
                        <td><a href="{{route('networks.show', $network->id)}}">{{$network->name}}</a></td>
                        <td>{{$network->users()->count()}}</td>
                        <td><a href="{{route('users.show', $network->owner->id)}}">{{$network->owner->name}}</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('network.nav')
@endsection
