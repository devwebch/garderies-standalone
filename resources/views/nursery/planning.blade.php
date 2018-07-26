@extends('layouts.app')

@section('title', 'Nursery')

@section('content')
    <div class="card card-default">
        <div class="card-header">Remplacements</div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Jour</th>
                    <th>Employé</th>
                    <th>Remplaçant</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Groupe</th>
                    <th>Tél. remplaçant</th>
                </tr>
                </thead>
                @forelse($bookings as $booking)
                    <tr>
                        <td><strong>{{$booking->start->format('l d.m.Y')}}</strong></td>
                        <td>{{$booking->user->name ?? '-'}}</td>
                        <td>{{$booking->substitute->name ?? '-'}}</td>
                        <td>{{$booking->start->format('H:i')}}</td>
                        <td>{{$booking->end->format('H:i')}}</td>
                        <td>{{$booking->request->workgroup->name}}</td>
                        <td>{{$booking->substitute->phone ?? '-'}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Pas de remplacement</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('nursery.nav')
@endsection
