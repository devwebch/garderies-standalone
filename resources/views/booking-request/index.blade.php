@extends('layouts.two-columns')

@section('title', 'Bookings requests')

@section('content')
    
    <div class="card card-default mb-4">
        <div class="card-header bg-dark text-white">Demandes de remplaçements</div>
        <div class="card-body">
            <table class="table table-borderless table-striped table-responsive-lg">
                <thead>
                <tr>
                    <th>Employé</th>
                    <th>Date</th>
                    <th>Remplaçant</th>
                    <th>Disponibilité</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @php
                    $last_timestamp = 0;
                @endphp

                @foreach($bookingRequests as $request)

                    @if ($last_timestamp != $request->start->timestamp)
                        <tr class="bg-dark text-white small">
                            <td colspan="5" class="p-2">
                                <strong>{{$request->start->format('d.m.Y')}}</strong>
                            </td>
                        </tr>
                    @endif

                    @php
                        $last_timestamp = $request->start->timestamp;
                    @endphp
                    <tr>
                        <td>
                            <a href="{{route('booking-requests.show', $request)}}">
                                {{$request->user->name ?? '-'}}
                            </a>
                        </td>
                        <td>
                            {{$request->start->format('d.m.Y')}}
                            -
                            {{$request->start->format('H\hi')}} <i class="fas fa-arrow-right"></i> {{$request->end->format('H\hi')}}
                        </td>
                        <td>
                            {{$request->substitute->name ?? '-'}}
                        </td>
                        <td>
                            @if ($request->availability)
                                {{$request->availability->start->format('H\hi')}}
                                <i class="fas fa-arrow-right"></i>
                                {{$request->availability->end->format('H\hi')}}
                            @endif
                        </td>
                        <td>
                            @switch($request->status)
                                @case(\App\BookingRequest::STATUS_PENDING)
                                <span class="badge badge-info">En attente</span>
                                @break
                                @case(\App\BookingRequest::STATUS_APPROVED)
                                <span class="badge badge-success">Validé</span>
                                @break
                                @case(\App\BookingRequest::STATUS_DENIED)
                                <span class="badge badge-danger">Refusé</span>
                                @break
                            @endswitch
                        </td>
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
