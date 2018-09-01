@extends('layouts.two-columns')

@section('title', 'Employés')

@section('content')
    <vue-table title="Employés" api-url="/api/users?nursery=0&network=0" :fields="[
            {
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
              title: 'Garderie'
            }, {
              name: '__slot:networkslinkrelation',
              sortField: 'networks.name',
              title: 'Réseaux',
              width: '150px'
            }]"></vue-table>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
