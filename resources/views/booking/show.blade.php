@extends('layouts.two-columns')

@section('title', 'Booking')

@section('content')
    <booking-show inline-template :booking-id="{{$booking->id}}" :user-id="{{$booking->user->id}}" :substitute-id="{{$booking->substitute->id}}">
        <div>
            <div class="card card-default">
                <div class="card-header">Remplacement du {{$booking->start->format('d.m.Y')}}
                    <div class="actions float-right d-print-none">
                        @if ($booking->status == \App\Booking::STATUS_PENDING)
                            <a href="{{route('bookings.edit', [$booking->id])}}" class="btn btn-info btn-sm mr-2"><i
                                        class="fas fa-edit"></i> Editer</a>
                            <a href="#" v-on:click.prevent="validateBooking({{$booking->id}})"
                               class="btn btn-success btn-sm mr-2"><i class="fas fa-check"></i> Valider</a>
                        @endif
                        <a href="#" v-on:click.prevent="addFeedback({{$booking->id}})" class="btn btn-info btn-sm"><i
                                    class="far fa-clipboard"></i> Ajouter un rapport</a>
                        <a href="#" v-on:click.prevent="deleteBooking({{$booking->id}})"
                           class="btn btn-danger btn-sm"><i class="fas fa-edit"></i> Supprimer</a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <td><strong>Date :</strong></td>
                                    <td>{{$booking->start->format('d.m.Y')}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Horaire :</strong></td>
                                    <td>{{$booking->start->format('H:i')}} - {{$booking->end->format('H:i')}}</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Durée :</strong></td>
                                    <td>{{$booking_duration}} h</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <td><strong>Garderie :</strong></td>
                                    <td>
                                        <a href="{{route('nurseries.show', $booking->nursery ?? 0)}}">{{$booking->nursery->name ?? '-'}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Groupe de travail :</strong></td>
                                    <td>{{$booking->request->workgroup->name ?? '-'}}</td>
                                </tr>
                                @if ($booking->request)
                                    <tr>
                                        <td><strong>Demande originale :</strong></td>
                                        <td>{{$booking->request->workgroup->name ?? '-'}}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if ($matching_pct)
                        <div class="progress d-print-none">
                            <div class="progress-bar progress-bar-striped bg-transparent text-dark" role="progressbar"
                                 style="width: {{$matching_start_pct}}%" aria-valuenow="{{$matching_start_pct}}"
                                 aria-valuemin="0" aria-valuemax="100">{{$booking->request->start->format('H:i')}}</div>
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{$matching_pct}}%"
                                 aria-valuenow="{{$matching_pct}}" aria-valuemin="0"
                                 aria-valuemax="100">{{$booking->start->format('H:i')}}
                                - {{$booking->end->format('H:i')}}</div>
                            <div class="progress-bar progress-bar-striped bg-transparent text-dark" role="progressbar"
                                 style="width: {{$matching_end_pct}}%" aria-valuenow="{{$matching_end_pct}}"
                                 aria-valuemin="0" aria-valuemax="100">{{$booking->request->end->format('H:i')}}</div>
                        </div>
                    @endif

                    <hr>

                    <div class="row">
                        <div class="col-md-6 text-center">
                            @if ($booking->substitute)
                                <div class="card bg-light">
                                    <div class="card-header text-center">Remplaçant</div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <div class="avatar avatar--sm mb-2">
                                                {!! Avatar::create($booking->substitute->name)->toSvg() !!}
                                            </div>
                                            <h4>{{$booking->substitute->name ?? '-'}}</h4>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 mb-4 mb-sm-0 text-center">
                            @if ($booking->user)
                                <div class="card bg-light">
                                    <div class="card-header text-center">Employé</div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <div class="avatar avatar--sm mb-2">
                                                {!! Avatar::create($booking->user->name)->toSvg() !!}
                                            </div>
                                            <h4>{{$booking->user->name ?? '-'}}</h4>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <p><strong>Message pour le remplaçant :</strong></p>
                            <p class="mb-0">{{optional($booking->request)->message ?? '-'}}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col">
                            <strong>Rapports</strong>
                            <ul>
                                @foreach($feedbacks as $feedback)
                                <li>{{$feedback->created_at->format('d.m.y H:i')}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <a href="{{ route('bookings.index') }}" class="btn btn-outline-primary btn-back">&larr; Retour</a>
                </div>
            </div>

            <div class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ajouter un rapport</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Titre</label>
                                <input type="text" class="form-control" name="name" id="name" v-model="feedback.name">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" cols="30" rows="7"
                                          class="form-control" v-model="feedback.description"></textarea>
                            </div>

                            <label>Note</label>
                            <div>
                                <vue-stars name="booking-rating"
                                           :active-color="'#ffdd00'"
                                           :inactive-color="'#DDDDDD'"
                                           :shadow-color="'#ffff00'"
                                           :hover-color="'#ffdd00'"
                                           :max="5"
                                           :value="3"
                                           v-model="feedback.rating"
                                           :readonly="false"
                                           char="★"
                                ></vue-stars>
                                <div class="quotes d-inline">
                                    <span v-show="feedback.rating == 1"><em>Problématique</em></span>
                                    <span v-show="feedback.rating == 2"><em>Tumultueux</em></span>
                                    <span v-show="feedback.rating == 3"><em>Sans incident</em></span>
                                    <span v-show="feedback.rating == 4"><em>Bien</em></span>
                                    <span v-show="feedback.rating == 5"><em>Très bien</em></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-primary" v-on:click="saveFeedback">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </booking-show>
@endsection

@section('nav-lateral')
    @include('booking.nav')
@endsection

@section('styles')
    <style>
        @media print {
            .content {
                max-width: none;
                flex: 100%;
            }

        }
    </style>
@endsection