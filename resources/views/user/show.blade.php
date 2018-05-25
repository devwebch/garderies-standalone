@extends('layouts.two-columns')

@section('title', $user->name)

@section('content')
    <user-show inline-template>
        <div>
            <div class="card card-default mb-4">
                <div class="card-header">{{$user->name}}
                    <div class="actions float-right">
                        <a href="{{route('users.edit', [$user->id])}}" class="btn btn-info btn-sm mr-2"><i class="fas fa-edit"></i> Editer</a>
                        <a href="{{route('users.edit', [$user->id])}}" v-on:click.prevent="deleteUser({{$user->id}})" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Supprimer</a>
                    </div>
                </div>
                <div class="card-body">
                    <p><strong>Nom :</strong> {{$user->name}}</p>
                    <p><strong>E-mail :</strong> {{$user->email}}</p>
                    <p><strong>Téléphone :</strong> {{$user->phone}}</p>
                    <p><strong>Garderie :</strong> {{$user->nursery->name ?? '-'}}</p>

                    <p><a href="{{route('users.availabilities', $user->id)}}" class="btn btn-info"><i class="fas fa-calendar"></i> Availabilities</a></p>
                </div>
            </div>
            <div class="card card-default mb-4">
                <div class="card-header">Vos prochaines disponibilités</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Day</th>
                            <th>Start</th>
                            <th>End</th>
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
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Day</th>
                            <th>Start</th>
                            <th>End</th>
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
