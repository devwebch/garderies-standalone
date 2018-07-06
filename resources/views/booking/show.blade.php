@extends('layouts.two-columns')

@section('title', 'Booking')

@section('content')
    <booking-show inline-template>
        <div class="card card-default">
            <div class="card-header">Remplacement du {{$booking->start->format('d.m.Y')}}
                <div class="actions float-right">
                    @if ($booking->status == \App\Booking::STATUS_PENDING)
                        <a href="{{route('bookings.edit', [$booking->id])}}" class="btn btn-info btn-sm mr-2"><i class="fas fa-edit"></i> Editer</a>
                        <a href="#" v-on:click.prevent="validateBooking({{$booking->id}})" class="btn btn-success btn-sm mr-2"><i class="fas fa-check"></i> Valider</a>
                    @endif
                    <a href="#" v-on:click.prevent="deleteBooking({{$booking->id}})" class="btn btn-danger btn-sm"><i class="fas fa-edit"></i> Supprimer</a>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <p><strong>Date :</strong> {{$booking->start->format('d.m.Y')}}</p>
                        <p><strong>Début :</strong> {{$booking->start->format('H\hi')}}</p>
                        <p><strong>Fin :</strong> {{$booking->end->format('H\hi')}}</p>
                        <p><strong>Employé :</strong> <a href="{{route('users.show', $booking->user ?? 0)}}">{{$booking->user->name ?? '-'}}</a></p>
                        <p><strong>Remplaçant :</strong> <a href="{{route('users.show', $booking->substitute ?? 0)}}">{{$booking->substitute->name ?? '-'}}</a></p>
                        <p><strong>Etablissement :</strong> <a href="{{route('nurseries.show', $booking->nursery ?? 0)}}">{{$booking->nursery->name ?? '-'}}</a></p>
                        <p><strong>Status :</strong>
                            @switch($booking->status)
                                @case(\App\Booking::STATUS_PENDING)
                                <span class="badge badge-info">En attente de validation</span>
                                @break
                                @case(\App\Booking::STATUS_APPROVED)
                                <span class="badge badge-success">Validé</span>
                                @break
                                @case(\App\Booking::STATUS_ARCHIVED)
                                <span class="badge badge-dark">Archivé</span>
                                @break
                            @endswitch
                        </p>
                    </div>
                    <div class="col">
                        @if ($booking->request)
                            <p><strong>Demande originale</strong></p>
                            <a href="{{route('booking-requests.show', $booking->request)}}">Voir la demande</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </booking-show>
@endsection

@section('nav-lateral')
    @include('booking.nav')
@endsection
