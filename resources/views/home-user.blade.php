@extends('layouts.app')

@section('title', 'Logiciels de gestion de garderie')

@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-calendar-alt"></i> Vos prochains remplacements</div>
                <div class="card-body">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Garderie</th>
                                <th>Début</th>
                                <th>Fin</th>
                                <th width="50"></th>
                            </tr>
                        </thead>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>{{$booking->start->format('d.m.Y')}}</td>
                            <td><a href="#">{{$booking->nursery->name ?? '-'}}</a></td>
                            <td>{{$booking->start->format('H:i')}}</td>
                            <td>{{$booking->end->format('H:i')}}</td>
                            <td><a href="#">Voir</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4 bg-primary text-white">
                <div class="card-header"><i class="fas fa-user-clock"></i> Vos disponibilités</div>
                <div class="card-body">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Début</th>
                            <th>Fin</th>
                        </tr>
                        </thead>
                        @foreach($availabilities as $availability)
                            <tr>
                                <td>{{$availability->start->format('d.m.Y')}}</td>
                                <td>{{$availability->start->format('H:i')}}</td>
                                <td>{{$availability->end->format('H:i')}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-list"></i> Demandes de remplacement en attente</div>
                <div class="card-body">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Garderie</th>
                            <th>Employé</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th width="50"></th>
                        </tr>
                        </thead>
                        @foreach($bookingRequests as $bookingRequest)
                            <tr>
                                <td>{{$bookingRequest->start->format('d.m.Y')}}</td>
                                <td>{{$bookingRequest->nursery->name ?? '-'}}</td>
                                <td>{{$bookingRequest->user->name ?? '-'}}</td>
                                <td>{{$bookingRequest->start->format('H:i')}}</td>
                                <td>{{$bookingRequest->end->format('H:i')}}</td>
                                <td><a href="#">Voir</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="view-select d-none d-xl-block">
        <ul class="list-inline m-0 p-0">
            <li class="list-inline-item"><a href="/">Vue administration</a></li>
            <li class="list-inline-item"><a href="/home2">Vue utilisateur</a></li>
        </ul>
    </div>
@endsection

@section('styles')
    <style>
        .view-select {
            position: fixed;
            left: 0;
            bottom: 0;
            background: #fff;
            padding: 10px;
        }
    </style>
@endsection