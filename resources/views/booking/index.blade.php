@extends('layouts.two-columns')

@section('title', 'Bookings')

@section('content')
    
    <my-vuetable title="Remplaçements" api-url="/api/bookings" :statuses="{
        pending: {{ \App\Booking::STATUS_PENDING }},
        approved: {{ \App\Booking::STATUS_APPROVED }},
        archived: {{ \App\Booking::STATUS_ARCHIVED }},
    }" :fields="[{
              name: '__slot:bookinglink',
              sortField: 'bookings.start',
              title: 'Date'
            }, {
              name: '__slot:userbookinglink',
              sortField: 'users.name',
              title: 'Employé'
            }, {
              name: '__slot:substitutelink',
              sortField: 'substitutes.name',
              title: 'Remplaçant'
            }, {
              name: '__slot:nurserylinkrelation',
              sortField: 'nurseries.name',
              title: 'Etablissement'
            }, {
              name: 'start',
              sortField: 'start',
              title: 'Début',
              callback: 'formatTime'
            }, {
              name: 'end',
              sortField: 'end',
              title: 'Fin',
              callback: 'formatTime'
            }, {
              name: 'status',
              sortField: 'status',
              title: 'Status',
              callback: 'statusLabel'
            }]"></my-vuetable>
    
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
