@extends('layouts.two-columns')

@section('title', 'Réseaux')

@section('content')
    <div class="card card-default">
        <div class="card-header bg-dark text-white">Réseaux</div>
        <div class="card-body">
            <my-vuetable :fields="[{
              name: '__slot:linklabel',
              sortField: 'networks.name',
              title: 'Nom'
            }, {
              name: 'users_count',
              sortField: 'users_count',
              title: 'Employés'
            }, {
              name: '__slot:ownerlink',
              sortField: 'users.name',
              title: 'Administrateur'
            }]"></my-vuetable>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('network.nav')
@endsection
