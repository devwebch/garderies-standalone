@extends('layouts.two-columns')

@section('title', 'Nursery')

@section('content')
    <nursery-show inline-template>
        <div>
            <div class="card card-default mb-4">
                <div class="card-header">{{$nursery->name}}
                    <div class="actions float-right">
                        <a href="{{route('nurseries.edit', [$nursery->id])}}" class="btn btn-info btn-sm mr-2"><i class="fas fa-edit"></i> Editer</a>
                        <a href="#" v-on:click.prevent="deleteNursery({{$nursery->id}})" class="btn btn-danger btn-sm"><i class="fas fa-edit"></i> Supprimer</a>
                    </div>
                </div>

                <div class="card-body">
                    <p><strong>Adresse :</strong> {{$nursery->address}}</p>
                    <p><strong>Localité :</strong> {{$nursery->post_code . ', ' ?? ''}}{{$nursery->city}}</p>
                    <p><strong>Téléphone :</strong> {{$nursery->phone}}</p>
                    <p><strong>E-mail :</strong> {{$nursery->email}}</p>
                </div>
            </div>

            <users :nursery="{{$nursery->id}}"></users>

            <div class="card card-default">
                <div class="card-header">Remplacements</div>
                <div class="card-body">
                    <table class="table table-borderless table-striped table-responsive-md">
                        <thead>
                        <tr>
                            <th>Employé</th>
                            <th>Remplaçant</th>
                            <th>Jour</th>
                            <th>Début</th>
                            <th>Fin</th>
                        </tr>
                        </thead>
                        @forelse($bookings as $booking)
                            <tr>
                                <td><a href="{{route('users.show', $booking->user->id)}}">{{$booking->user->name}}</a></td>
                                <td><a href="{{route('users.show', $booking->substitute->id)}}">{{$booking->substitute->name}}</a></td>
                                <td>{{\Carbon\Carbon::parse($booking->start)->format('d.m.Y')}}</td>
                                <td>{{\Carbon\Carbon::parse($booking->start)->format('H:i')}}</td>
                                <td>{{\Carbon\Carbon::parse($booking->end)->format('H:i')}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Pas de remplacement</td>
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
