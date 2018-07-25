@extends('layouts.two-columns')

@section('title', 'Demande de remplaçement')

@section('content')
    <booking-request-show inline-template>
        <div class="card card-default">
            <div class="card-header">
                Demande de remplaçement pour le {{$bookingRequest->start->format('d.m.Y')}}

                <div class="actions float-right">
                    @if ($bookingRequest->status == \App\BookingRequest::STATUS_PENDING && $bookingRequest->availability->status == \App\Availability::STATUS_UNTOUCHED)
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

                @if (($bookingRequest->availability->status == \App\Availability::STATUS_BOOKED || $bookingRequest->availability->status == \App\Availability::STATUS_ARCHIVED))
                        <div class="alert alert-warning">Le remplacant n'est plus disponible pour cet horaire</div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-4 mb-sm-0">
                        <div class="card border">
                            <div class="card-header bg-secondary text-white">Employé</div>
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="mb-2">
                                        {!! Avatar::create($bookingRequest->user->name)->setDimension(140, 140)->toSvg() !!}
                                    </div>
                                    <h4>{{$bookingRequest->user->name ?? '-'}}</h4>
                                </div>
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
                            <div class="card-header bg-primary text-white">Remplaçant</div>
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="mb-2">
                                        {!! Avatar::create($bookingRequest->substitute->name)->setDimension(140, 140)->toSvg() !!}
                                    </div>
                                    <h4>{{$bookingRequest->substitute->name ?? '-'}}</h4>
                                </div>
                                <hr>
                                @if ($bookingRequest->availability)
                                    <p class="text-muted">Disponibilité proposée par le remplacant.</p>
                                    <p><strong>Date :</strong> {{$availability->start->format('d.m.Y')}}</p>
                                    <p>
                                        <strong>Dès :</strong>
                                        @if (!$conflict_start)
                                            <span class="text-success">{{$availability->start->format('H\hi')}}</span>
                                        @else
                                            <span class="text-danger" data-toggle="tooltip" title="Le remplacant n'est pas disponible dès l'heure de début">{{$availability->start->format('H\hi')}}</span>
                                        @endif
                                    </p>
                                    <p>
                                        <strong>Jusqu'à :</strong>
                                        @if (!$conflict_end)
                                            <span class="text-success">{{$availability->end->format('H\hi')}}</span>
                                        @else
                                            <span class="text-danger" data-toggle="tooltip" title="Le remplacant n'est pas disponible jusqu'à l'heure de fin">{{$availability->end->format('H\hi')}}</span>
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Garderie :</strong>
                            <a href="{{route('nurseries.show', $bookingRequest->nursery ?? 0)}}">{{$bookingRequest->nursery->name ?? '-'}}</a>
                        </p>
                        <p><strong>Groupe de travail :</strong> {{$bookingRequest->workgroup->name ?? '-'}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Message pour le remplaçant :</strong></p>
                        <p class="mb-0">{{$bookingRequest->message}}</p>
                    </div>
                </div>

            </div>
        </div>
    </booking-request-show>
@endsection

@section('nav-lateral')
    @include('booking.nav')
@endsection
