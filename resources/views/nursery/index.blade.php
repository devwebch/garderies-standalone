@extends('layouts.two-columns')

@section('title', 'Home')

@section('content')
    <my-vuetable title="Etablissements" api-url="/api/nurseries" :fields="[{
            name: '__slot:nurserylink',
            sortField: 'nurseries.name',
            title: 'Nom'
        }, {
            name: 'users_count',
            sortField: 'users_count',
            title: 'Employés',
            titleClass: 'text-right',
            dataClass: 'text-right'
        }, {
            name: '__slot:networklinkrelation',
            sortField: 'networks.name',
            title: 'Réseaux'
        }]">
    </my-vuetable>
@endsection

@section('nav-lateral')
    @include('nursery.nav')
@endsection
