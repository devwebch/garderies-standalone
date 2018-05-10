@extends('layouts.two-columns')

@section('title', $user->name)

@section('content')
    <div class="card card-default">
        <div class="card-header">{{$user->id}} - {{$user->name}}</div>
        <div class="card-body">
            <user-availabilities user="{{$user->id}}"></user-availabilities>

            <h3 class="text-success mt-4">Availabilities</h3>
            <table class="table">
                <thead>
                <tr>
                    <th>Start</th>
                    <th>End</th>
                    <th>Hours</th>
                </tr>
                </thead>
                @foreach($availabilities as $slot)
                    <tr>
                        <td>{{$slot->start}}</td>
                        <td>{{$slot->end}}</td>
                        <td>{{$slot->hours}}h</td>
                    </tr>
                @endforeach
            </table>

            <h3 class="text-danger">Bookings</h3>
            <table class="table">
                <thead>
                <tr>
                    <th>Start</th>
                    <th>End</th>
                    <th>Hours</th>
                </tr>
                </thead>
                @foreach($bookings as $slot)
                    <tr>
                        <td>{{$slot->start}}</td>
                        <td>{{$slot->end}}</td>
                        <td>{{$slot->hours}}h</td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
