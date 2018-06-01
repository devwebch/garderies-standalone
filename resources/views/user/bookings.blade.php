@extends('layouts.two-columns')

@section('title', $user->name)

@section('content')
    <div class="card card-default">
        <div class="card-header">Vos prochains remplacements</div>
        <div class="card-body">
            <table class="table table-responsive-md">
                <thead>
                <tr>
                    <th>Jour</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Etablissement</th>
                </tr>
                </thead>
                @foreach($bookings as $slot)
                    <tr>
                        <td>{{$slot->day_start}}</td>
                        <td>{{$slot->hour_start}}</td>
                        <td>{{$slot->hour_end}}</td>
                        <td>{{$slot->nursery->name}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
