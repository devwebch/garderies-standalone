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

                <div class="booking-hours text-center pt-2 pb-4" style="font-size: 2em;">
                    <span class="start">{{$booking->start->format('H:i')}}</span>
                    <span class="operator"><i class="fas fa-arrow-right"></i></span>
                    <span class="end">{{$booking->end->format('H:i')}}</span>
                </div>

                <div class="progress">
                    <div class="progress-bar progress-bar-striped bg-secondary" role="progressbar" style="width: {{$start_pct}}%" aria-valuenow="{{$start_pct}}" aria-valuemin="0" aria-valuemax="100">{{$booking->request->start->format('H:i')}}</div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{$completion_pct}}%" aria-valuenow="{{$completion_pct}}" aria-valuemin="0" aria-valuemax="100">{{$booking->start->format('H:i')}} - {{$booking->end->format('H:i')}}</div>
                    <div class="progress-bar progress-bar-striped bg-secondary" role="progressbar" style="width: {{$end_pct}}%" aria-valuenow="{{$end_pct}}" aria-valuemin="0" aria-valuemax="100">{{$booking->request->end->format('H:i')}}</div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6 mb-4 mb-sm-0">
                        @if ($booking->user)
                        <div class="card border">
                            <div class="card-header bg-secondary text-white">
                                Employé
                            </div>
                            <div class="card-body">
                                <h4><a href="{{route('users.show', $booking->user)}}">{{$booking->user->name}}</a></h4>
                                <hr>
                                @if ($booking->request)
                                    <p class="text-muted">Demande de remplacement faite par l'employé.</p>
                                    <p><strong>Date :</strong> {{$booking->request->start->format('d.m.Y')}}</p>
                                    <p><strong>Début :</strong> {{$booking->request->start->format('H\hi')}}</p>
                                    <p><strong>Fin :</strong> {{$booking->request->end->format('H\hi')}}</p>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if ($booking->substitute)
                        <div class="card border">
                            <div class="card-header bg-primary text-white">
                                Remplaçant
                            </div>
                            <div class="card-body">
                                <h4><a href="{{route('users.show', $booking->substitute)}}">{{$booking->substitute->name}}</a></h4>
                                <hr>
                                @if (optional($booking->request)->availability)
                                    <p class="text-muted">Disponibilité proposée par le remplacant.</p>
                                    <p><strong>Date :</strong> {{$booking->request->availability->start->format('d.m.Y')}}</p>
                                    <p><strong>Dès :</strong> {{$booking->request->availability->start->format('H\hi')}}</p>
                                    <p><strong>Jusqu'à :</strong> {{$booking->request->availability->end->format('H\hi')}}</p>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Garderie :</strong>
                            <a href="{{route('nurseries.show', $booking->nursery ?? 0)}}">{{$booking->nursery->name ?? '-'}}</a>
                        </p>
                        <p><strong>Groupe de travail :</strong> {{$booking->request->workgroup->name ?? '-'}}</p>
                        @if ($booking->request)
                            <p><strong>Demande originale :</strong> <a href="{{route('booking-requests.show', $booking->request)}}">Voir la demande</a></p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <p><strong>Message pour le remplaçant :</strong></p>
                        <blockquote class="blockquote">
                            <p class="mb-0">{{$booking->request->message}}</p>
                        </blockquote>
                    </div>
                </div>

            </div>

        </div>
    </booking-show>
@endsection

@section('nav-lateral')
    @include('booking.nav')
@endsection
