@extends('layouts.two-columns')

@section('title', 'Réseaux')

@section('content')
    <div class="card card-default">
        <div class="card-header bg-dark text-white"><div class="row"><div class="col-md-6">Réseaux</div><div class="col-md-6"><filter-bar></filter-bar></div></div></div>
        <div class="card-body">
            <my-vuetable api-url="/api/networks" :fields="[{
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
