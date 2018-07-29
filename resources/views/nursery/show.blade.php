@extends('layouts.two-columns')

@section('title', $nursery->name)

@section('content')
    <nursery-show inline-template>
        <div>
            <div class="card card-default mb-4">
                <div class="card-header">{{$nursery->name}}
                    <div class="actions float-right">
                        <a href="{{route('nurseries.edit', [$nursery])}}" class="btn btn-info btn-sm mr-2"><i class="fas fa-edit"></i> Editer</a>
                        <a href="#" v-on:click.prevent="deleteNursery('{{$nursery->slug}}')" class="btn btn-danger btn-sm"><i class="fas fa-edit"></i> Supprimer</a>
                    </div>
                </div>

                <div class="card-body">
                    <p><strong>Adresse :</strong> {{$nursery->address}}</p>
                    <p><strong>Localité :</strong> {{$nursery->post_code . ', ' ?? ''}}{{$nursery->city}}</p>
                    <p><strong>Téléphone :</strong> {{$nursery->phone}}</p>
                    <p><strong>E-mail :</strong> {{$nursery->email}}</p>
                    <p>
                        <strong>Réseau :</strong>
                        @if ($nursery->network)
                            <a href="{{route('networks.show', $nursery->network)}}">
                                <span class="badge text-white" style="background-color: {{$nursery->network->color ?? '#ccc'}};">{{$nursery->network->name}}</span>
                            </a>
                        @else
                            <span class="badge text-white" style="background-color: {{$nursery->network->color ?? '#ccc'}};">-</span>
                        @endif
                        
                    </p>
                </div>
            </div>
    
            <vue-table title="Employés" api-url="/api/users?nursery={{$nursery->id}}&network=0" :fields="[{
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
              name: '__slot:networkslinkrelation',
              sortField: 'networks.name',
              title: 'Réseaux'
            }]"></vue-table>
    
            <vue-table title="Remplacements" api-url="/api/bookings?nursery={{$nursery->id}}" :fields="[{
              name: '__slot:userbookinglink',
              sortField: 'users.name',
              title: 'Employé'
            }, {
              name: '__slot:substitutelink',
              sortField: 'substitutes.name',
              title: 'Remplaçant'
            }, {
              name: '__slot:bookinglink',
              sortField: 'bookings.start',
              title: 'Date'
            }, {
              name: 'start',
              sortField: 'start',
              title: 'Début',
              callback: 'formatTime'
            }, {
              name: 'end',
              sortField: 'end',
              title: 'Fin',
              callback: 'formatTime'
            }, {
              name: '__slot:bookingShowlink',
              title: ''
            }]"></vue-table>
        </div>
    </nursery-show>
@endsection

@section('nav-lateral')
    @include('nursery.nav')
@endsection
