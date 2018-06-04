@extends('layouts.two-columns')

@section('title', 'Bookings')

@section('content')
    <table class="table table-borderless table-striped table-responsive-md">
        <thead>
            <tr>
                <th>User</th>
                <th>Substitute</th>
                <th>Nursery</th>
                <th>Date</th>
                <th>Start</th>
                <th>End</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>
                    <a href="{{route('users.show', $booking->user->id)}}">{{$booking->user->name}}</a>
                </td>
                <td>
                    <a href="{{route('users.show', $booking->substitute->id)}}">{{$booking->substitute->name}}</a>
                </td>
                <td>
                    <a href="{{route('nurseries.show', $booking->nursery->id)}}">{{$booking->nursery->name}}</a>
                </td>
                <td>{{\Carbon\Carbon::parse($booking->start)->format('d.m.Y')}}</td>
                <td>{{\Carbon\Carbon::parse($booking->start)->format('H\hi')}}</td>
                <td>{{\Carbon\Carbon::parse($booking->end)->format('H\hi')}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection

@section('nav-lateral')
    @include('nursery.nav')
@endsection
