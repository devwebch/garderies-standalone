@extends('layouts.two-columns')

@section('title', 'Réseaux')

@section('content')
    
            <my-vuetable title="Réseaux" api-url="/api/networks" :fields="[{
              name: '__slot:networklink',
              sortField: 'networks.name',
              title: 'Nom'
            }, {
              name: 'users_count',
              sortField: 'users_count',
              title: 'Employés',
              titleClass: 'text-right',
              dataClass: 'text-right'
            }, {
              name: '__slot:ownerlink',
              sortField: 'users.name',
              title: 'Administrateur'
            }]"></my-vuetable>
        
@endsection

@section('nav-lateral')
    @include('network.nav')
@endsection
