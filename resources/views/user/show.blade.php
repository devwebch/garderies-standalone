@extends('layouts.two-columns')

@section('title', $user->name)

@section('content')
    <user-show inline-template>
        <div>
            <div class="card card-default mb-4">
                <div class="card-header">{{$user->name}}
                    <div class="actions float-right">
                        <a href="{{route('users.edit', [$user->id])}}" class="btn btn-info btn-sm mr-2"><i class="fas fa-edit"></i> Editer</a>
                        <a href="#" v-on:click.prevent="deleteUser({{$user->id}})" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Supprimer</a>
                    </div>
                </div>
                <div class="card-body user-card">
                    <div class="row">
                        <div class="col">
                            <p><strong>Nom :</strong> {{$user->name}}</p>
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
                                <img src="{{asset('img/dummy_avatar.jpg')}}" alt="User profile picture">
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
                        </tr>
                        </thead>
                        @foreach($availabilities as $slot)
                            <tr>
                                <td>{{$slot->day_start}}</td>
                                <td>{{$slot->hour_start}}</td>
                                <td>{{$slot->hour_end}}</td>
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
                        </tr>
                        </thead>
                        @foreach($bookings as $slot)
                            <tr>
                                <td>{{$slot->day_start}}</td>
                                <td>{{$slot->hour_start}}</td>
                                <td>{{$slot->hour_end}}</td>
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
