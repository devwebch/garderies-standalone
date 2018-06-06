@extends('layouts.two-columns')

@section('title', 'Bookings')

@section('content')
    <div class="card card-default mb-4">
        <div class="card-header bg-dark text-white">Remplaçements</div>
        <div class="card-body">
            <table class="table table-borderless table-striped table-responsive-lg">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Employé</th>
                    <th>Remplaçant</th>
                    <th>Etablissement</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td>
                            <a href="{{route('bookings.show', $booking->id)}}">
                                {{$booking->start->format('d.m.Y')}}
                            </a>
                        </td>
                        <td>
                            <a href="{{route('users.show', $booking->user->id)}}">{{$booking->user->name}}</a>
                        </td>
                        <td>
                            <a href="{{route('users.show', $booking->substitute->id)}}">{{$booking->substitute->name}}</a>
                        </td>
                        <td>
                            <a href="{{route('nurseries.show', $booking->nursery->id)}}">{{$booking->nursery->name}}</a>
                        </td>
                        <td>{{$booking->start->format('H\hi')}}</td>
                        <td>{{$booking->end->format('H\hi')}}</td>
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
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header">Remplacements archivés</div>
        <div class="card-body">
            <table class="table table-borderless table-sm table-striped table-responsive-lg">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Employé</th>
                    <th>Remplaçant</th>
                    <th>Etablissement</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bookings_archive as $booking)
                    <tr>
                        <td>
                            <a href="{{route('bookings.show', $booking->id)}}">
                                {{$booking->start->format('d.m.Y')}}
                            </a>
                        </td>
                        <td>
                            <a href="{{route('users.show', $booking->user->id)}}">{{$booking->user->name}}</a>
                        </td>
                        <td>
                            <a href="{{route('users.show', $booking->substitute->id)}}">{{$booking->substitute->name}}</a>
                        </td>
                        <td>
                            <a href="{{route('nurseries.show', $booking->nursery->id)}}">{{$booking->nursery->name}}</a>
                        </td>
                        <td>{{$booking->start->format('H\hi')}}</td>
                        <td>{{$booking->end->format('H\hi')}}</td>
                        <td><span class="badge badge-dark">Archivé</span></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('booking.nav')
@endsection
