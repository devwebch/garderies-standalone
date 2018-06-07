@extends('layouts.two-columns')

@section('title', $user->name)

@section('content')
    <user-show inline-template>
        <div>
            <div class="card card-default mb-4">
                <div class="card-header bg-dark text-white">{{$user->name}}
                    <div class="actions float-right">
                        <a href="{{route('users.edit', [$user->id])}}" class="btn btn-info btn-sm mr-2"><i class="fas fa-edit"></i> Editer</a>
                        <a href="#" v-on:click.prevent="deleteUser({{$user->id}})" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Supprimer</a>
                    </div>
                </div>
                <div class="card-body user-card">
                    <div class="row">
                        <div class="col">
                            <p><strong>E-mail :</strong> {{$user->email}}</p>
                            <p><strong>Téléphone :</strong> {{$user->phone}}</p>
                            <p><strong>Garderie :</strong> {{$user->nursery->name ?? '-'}}</p>
                            <p><strong>Diplôme :</strong> {{$user->diploma->name}}</p>

                            <p><strong>Groupes de travail :</strong>
                                @foreach($user->workgroups as $workgroup)
                                    <span class="badge badge-warning">{{$workgroup->name}}</span>
                                @endforeach
                            </p>

                            <p><strong>Réseaux :</strong>
                                @foreach($user->networks as $network)
                                    <span class="badge badge-info">{{$network->name}}</span>
                                @endforeach
                            </p>
                        </div>
                        <div class="col">
                            <div class="user-card__avatar text-right">
                                <img src="{{asset($avatar)}}" alt="User profile picture">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-default mb-4">
                <div class="card-header">
                    Vos prochaines disponibilités
                    <div class="actions float-right">
                        <a href="{{route('users.availabilities', $user->id)}}" class="btn btn-info btn-sm"><i class="fas fa-calendar"></i> Gérer mes disponibilités</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-striped table-responsive-lg">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th width="120">Status</th>
                            <th width="50"></th>
                        </tr>
                        </thead>
                        @foreach($availabilities as $availability)
                            <tr>
                                <td>{{$availability->start->format('d.m.Y')}}</td>
                                <td>{{$availability->start->format('H\hi')}}</td>
                                <td>{{$availability->end->format('H\hi')}}</td>
                                <td>
                                    @switch($availability->status)
                                        @case(\App\Availability::STATUS_UNTOUCHED)
                                        <span class="badge badge-info">Libre</span>
                                        @break
                                        @case(\App\Availability::STATUS_BOOKED)
                                        <span class="badge badge-success">Réservé</span>
                                        @break
                                        @case(\App\Availability::STATUS_ARCHIVED)
                                        <span class="badge badge-dark">Archivé</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    @if ($availability->request)
                                    <a href="{{route('booking-requests.show', $availability->request)}}">Voir</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="card card-default">
                <div class="card-header">Vos prochains remplacements</div>
                <div class="card-body">
                    <table class="table table-borderless table-striped table-responsive-lg">
                        <thead>
                        <tr>
                            <th>Jour</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th>Etablissement</th>
                            <th width="120">Status</th>
                            <th width="50"></th>
                        </tr>
                        </thead>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{$booking->start->format('d.m.Y')}}</td>
                                <td>{{$booking->start->format('H\hi')}}</td>
                                <td>{{$booking->end->format('H\hi')}}</td>
                                <td><a href="{{route('nurseries.show', $booking->nursery)}}">{{$booking->nursery->name}}</a></td>
                                <td>
                                    @switch($booking->status)
                                        @case(\App\Booking::STATUS_PENDING)
                                        <span class="badge badge-info">En attente</span>
                                        @break
                                        @case(\App\Booking::STATUS_APPROVED)
                                        <span class="badge badge-success">Validé</span>
                                        @break
                                        @case(\App\Booking::STATUS_ARCHIVED)
                                        <span class="badge badge-dark">Archivé</span>
                                        @break
                                    @endswitch
                                </td>
                                <td><a href="{{route('bookings.show', $booking)}}">Voir</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </user-show>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
