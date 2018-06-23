@extends('layouts.two-columns')

@section('title', $network->name)

@section('content')

    <network-show inline-template>
        <div class="card card-default mb-4">
            <div class="card-header">
                {{$network->name}}
                <div class="actions float-right">
                    <a href="{{route('networks.edit', [$network->id])}}" class="btn btn-info btn-sm mr-2"><i class="fas fa-edit"></i> Editer</a>
                    <a href="#" v-on:click.prevent="deleteNetwork({{$network->id}})" class="btn btn-danger btn-sm"><i class="fas fa-edit"></i> Supprimer</a>
                </div>
            </div>
            <div class="card-body">
                <p><strong>Nom :</strong> {{$network->name}}</p>
                <p><strong>Administrateur :</strong> <a href="{{route('users.show', $network->owner->id)}}">{{$network->owner->name}}</a></p>
            </div>
        </div>
    </network-show>

    <my-vuetable title="Employés" api-url="/api/users?nursery=0&network={{$network->id}}" :fields="[{
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
            }]"></my-vuetable>
@endsection

@section('nav-lateral')
    @include('network.nav')
@endsection
