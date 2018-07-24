@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <user-show inline-template>
        <div>
            <div class="row">
                <div class="col mb-2">
                    <a href="{{route('users.index')}}" class="btn btn-info btn-sm">&larr; Retour aux utilisateurs</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-5">
                    <div class="card">
                        <div class="profile-card text-center">
                            <div class="card-body">

                                <div class="thumb-xl member-thumb mb-2 center-block">
                                    <img src="{{asset($avatar)}}" class="rounded-circle img-thumbnail" alt="User profile picture">
                                </div>
                                <div>
                                    <h5>{{$user->name}}</h5>
                                </div>
                                <div class="actions pt-2">
                                    <a href="{{route('users.edit', [$user->id])}}" class="btn btn-info btn-sm mr-2"><i class="fas fa-edit"></i> Editer</a>
                                    <a href="#" v-on:click.prevent="deleteUser({{$user->id}})" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Supprimer</a>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush text-left">
                                <li class="list-group-item">
                                    <strong>Téléphone :</strong>
                                    <span class="text-muted">
                                        <a href="tel:{{$user->phone}}">{{$user->phone}}</a>
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <strong>E-mail :</strong>
                                    <span class="text-muted">
                                        <a href="mailto:{{$user->email}}">{{$user->email}}</a>
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Garderie :</strong>
                                    <span class="text-muted">
                                        <a href="{{route('nurseries.show', $user->nursery)}}">{{$user->nursery->name ?? '-'}}</a>
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Diplôme :</strong> <span class="text-muted">{{$user->diploma->name ?? '-'}}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Préférences de contact :</strong>
                                    <span class="text-muted p-1" data-toggle="tooltip" title="Téléphone"><i class="fas fa-phone"></i></span>
                                    <span class="text-muted p-1" data-toggle="tooltip" title="E-mail"><i class="fas fa-envelope"></i></span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Groupes de travail :</strong>
                                    @foreach($user->workgroups as $workgroup)
                                        <span class="badge badge-warning">{{$workgroup->name}}</span>
                                    @endforeach
                                </li>
                                <li class="list-group-item">
                                    <strong>Réseaux :</strong>
                                    @foreach($user->networks as $network)
                                        <span class="badge badge-info">{{$network->name}}</span>
                                    @endforeach
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7">
                    <div class="card card-default mb-4">
                        <div class="card-header">
                            Vos prochaines disponibilités
                            <div class="actions float-right">
                                <a href="{{route('users.availabilities', $user->id)}}" class="btn btn-info btn-sm"><i class="fas fa-calendar"></i> Gérer mes disponibilités</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (!$availabilities->count())
                                <div class="alert alert-info">Aucune disponibilité renseignée pour le moment.</div>
                                <a href="{{route('users.availabilities', $user->id)}}" class="btn btn-info"><i class="fas fa-calendar"></i> Gérer mes disponibilités</a>
                            @else
                                <table class="table table-borderless table-striped table-responsive-lg">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Début</th>
                                        <th>Fin</th>
                                        <th width="30">Status</th>
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
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </div>
                    </div>
                    <div class="card card-default mb-4">
                        <div class="card-header">Demandes en attente</div>
                        <div class="card-body">
                            @if (!$bookingRequests->count())
                                <div class="alert alert-info">Aucune demande en attente.</div>
                            @else
                                <table class="table table-borderless table-striped table-responsive-lg">
                                    <thead>
                                    <tr>
                                        <th>Jour</th>
                                        <th>Début</th>
                                        <th>Fin</th>
                                        <th>Garderie</th>
                                        <th width="120">Status</th>
                                        <th width="50"></th>
                                    </tr>
                                    </thead>
                                    @foreach($bookingRequests as $request)
                                        <tr>
                                            <td>{{$request->start->format('d.m.Y')}}</td>
                                            <td>{{$request->start->format('H\hi')}}</td>
                                            <td>{{$request->end->format('H\hi')}}</td>
                                            <td><a href="{{route('nurseries.show', $request->nursery ?? 0)}}">{{$request->nursery->name ?? '-'}}</a></td>
                                            <td>
                                                @switch($request->status)
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
                                            <td><a href="{{route('booking-requests.show', $request)}}">Voir</a></td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </div>
                    </div>
                    <div class="card card-default">
                        <div class="card-header">Vos prochains remplacements</div>
                        <div class="card-body">
                            @if (!$bookings->count())
                                <div class="alert alert-info">Aucun remplacement prévu.</div>
                            @else
                                <table class="table table-borderless table-striped table-responsive-lg">
                                    <thead>
                                    <tr>
                                        <th>Jour</th>
                                        <th>Début</th>
                                        <th>Fin</th>
                                        <th>Garderie</th>
                                        <th width="120">Status</th>
                                        <th width="50"></th>
                                    </tr>
                                    </thead>
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td>{{$booking->start->format('d.m.Y')}}</td>
                                            <td>{{$booking->start->format('H\hi')}}</td>
                                            <td>{{$booking->end->format('H\hi')}}</td>
                                            <td><a href="{{route('nurseries.show', $booking->nursery ?? 0)}}">{{$booking->nursery->name ?? '-'}}</a></td>
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </user-show>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
