@extends('layouts.two-columns')

@section('title', 'Demande de remplaçement')

@section('content')
    <booking-request-show inline-template>
        <div class="card card-default">
            <div class="card-header">
                Demande de remplaçement pour le {{$bookingRequest->start->format('d.m.Y')}}

                <div class="actions float-right">
                    @if ($bookingRequest->status == \App\BookingRequest::STATUS_PENDING)
                        <a href="#" v-on:click.prevent="validateBookingRequest({{$bookingRequest->id}})" class="btn btn-success btn-sm mr-2"><i class="fas fa-check"></i> Valider</a>
                    @endif
                    <a href="#" v-on:click.prevent="deleteBookingRequest({{$bookingRequest->id}})" class="btn btn-danger btn-sm"><i class="fas fa-edit"></i> Supprimer</a>
                </div>
            </div>

            <div class="card-body">

                @switch($bookingRequest->status)
                    @case(\App\BookingRequest::STATUS_PENDING)
                    <div class="alert alert-info">Demande en attente</div>
                    @break
                    @case(\App\BookingRequest::STATUS_APPROVED)
                    <div class="alert alert-success">Demande approuvée</div>
                    @break
                    @case(\App\BookingRequest::STATUS_DENIED)
                    <div class="alert alert-danger">Demande refusée</div>
                    @break
                @endswitch

                <div class="row">
                    <div class="col-md-6 mb-4 mb-sm-0">
                        <div class="card border">
                            <div class="card-header bg-secondary text-white">
                                Employé
                            </div>
                            <div class="card-body">
                                <h4>{{$bookingRequest->user->name ?? '-'}}</h4>
                                <hr>
                                <p class="text-muted">Demande de remplacement faite par l'employé.</p>
                                <p><strong>Date :</strong> {{$bookingRequest->start->format('d.m.Y')}}</p>
                                <p><strong>Début :</strong> {{$bookingRequest->start->format('H\hi')}}</p>
                                <p><strong>Fin :</strong> {{$bookingRequest->end->format('H\hi')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border">
                            <div class="card-header bg-primary text-white">
                                Remplaçant
                            </div>
                            <div class="card-body">
                                <h4>{{$bookingRequest->substitute->name ?? '-'}}</h4>
                                <hr>
                                @if ($bookingRequest->availability)
                                    <p class="text-muted">Disponibilité proposée par le remplacant.</p>
                                    <p><strong>Date :</strong> {{$bookingRequest->availability->start->format('d.m.Y')}}</p>
                                    <p><strong>Dès :</strong> {{$bookingRequest->availability->start->format('H\hi')}}</p>
                                    <p><strong>Jusqu'à :</strong> {{$bookingRequest->availability->end->format('H\hi')}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Etablissement :</strong>
                            <a href="{{route('nurseries.show', $bookingRequest->nursery ?? 0)}}">{{$bookingRequest->nursery->name ?? '-'}}</a>
                        </p>
                        <p><strong>Groupe de travail :</strong> {{$bookingRequest->workgroup->name ?? '-'}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Message pour le remplaçant :</strong></p>
                        <blockquote class="blockquote">
                            <p class="mb-0">{{$bookingRequest->message}}</p>
                        </blockquote>
                    </div>
                </div>

            </div>
        </div>
    </booking-request-show>
@endsection

@section('nav-lateral')
    @include('booking.nav')
@endsection
