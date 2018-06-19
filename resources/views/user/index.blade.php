@extends('layouts.two-columns')

@section('title', 'Employés')

@section('content')
    <my-vuetable title="Employés" api-url="/api/users?nursery=0&network=0" :fields="[{
              name: '__slot:userlink',
              sortField: 'users.name',
              title: 'Nom et prénom'
            }, {
              name: 'phone',
              sortField: 'phone',
              title: 'Téléphone'
            }, {
              name: 'email',
              sortField: 'email',
              title: 'E-mail'
            }, {
              name: '__slot:nurserylinkrelation',
              sortField: 'nurseries.name',
              title: 'Etablissement'
            }, {
              name: '__slot:networklinkrelation',
              sortField: 'networks.name',
              title: 'Réseaux'
            }]"></my-vuetable>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
