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
                        <a href="{{route('networks.show', $nursery->network)}}">
                            <span class="badge text-white" style="background-color: {{$nursery->network->color ?? '#ccc'}};">{{$nursery->network->name ?? '-'}}</span>
                        </a>
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

            <div class="card card-default">
                <div class="card-header">Remplacements</div>
                <div class="card-body">
                    <table class="table table-borderless table-striped table-responsive-lg">
                        <thead>
                        <tr>
                            <th>Employé</th>
                            <th>Remplaçant</th>
                            <th>Jour</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th width="50"></th>
                        </tr>
                        </thead>
                        @forelse($bookings as $booking)
                            <tr>
                                <td><a href="{{route('users.show', $booking->user ?? 0)}}">{{$booking->user->name ?? '-'}}</a></td>
                                <td><a href="{{route('users.show', $booking->substitute ?? 0)}}">{{$booking->substitute->name ?? '-'}}</a></td>
                                <td>{{$booking->start->format('d.m.Y')}}</td>
                                <td>{{$booking->start->format('H:i')}}</td>
                                <td>{{$booking->end->format('H:i')}}</td>
                                <td>
                                    <a href="{{route('bookings.show', $booking)}}">Voir</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Pas de remplacement</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </nursery-show>
@endsection

@section('nav-lateral')
    @include('nursery.nav')
@endsection
