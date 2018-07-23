@extends('layouts.two-columns')

@section('title', 'Demandes de remplacement')

@section('content')
    
    <div class="card card-default mb-4">
        <div class="card-header bg-dark text-white">Demandes de remplaçements</div>
        <div class="card-body">
            <table class="table table-borderless table-striped table-responsive-lg">
                <thead>
                <tr>
                    <th>Employé</th>
                    <th>Horaire</th>
                    <th>Remplaçant</th>
                    <th>Disponibilité</th>
                    <th></th>
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
                            <td colspan="6" class="p-2">
                                <strong>{{$request->start->format('d.m.Y')}}</strong>
                            </td>
                        </tr>
                    @endif

                    @php
                        $last_timestamp = $request->start->timestamp;
                    @endphp
                    <tr>
                        <td>
                            <a href="{{route('users.show', $request->user->id ?? 0)}}">
                                {{$request->user->name ?? 'Aucun'}}
                            </a>
                        </td>
                        <td>
                            {{$request->start->format('H\hi')}} <i class="fas fa-arrow-right"></i> {{$request->end->format('H\hi')}}
                        </td>
                        <td>
                            <a href="{{route('users.show', $request->substitute->id ?? 0)}}" target="_blank">
                                {{$request->substitute->name ?? 'Aucun'}}
                            </a>
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
                        <td>
                            <a href="{{route('booking-requests.show', $request)}}">Voir</a>
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
