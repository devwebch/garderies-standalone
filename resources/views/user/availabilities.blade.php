@extends('layouts.app')

@section('title', 'Disponibilités')

@section('content')
    <div class="wrapper">
        <div class="row">
            <div class="col mb-2">
                <a href="{{route('users.show', $user)}}" class="btn btn-info btn-sm">&larr; Retour au profil</a>
            </div>
        </div>
        <div class="card card-default">
            <div class="card-header">{{$user->name}}</div>
            <div class="card-body">
                <user-availabilities
                        user="{{$user->id}}"
                        opening-time="{{$opening_time}}"
                        closing-time="{{$closing_time}}"
                        default-date="{{$current_day}}"
                ></user-availabilities>
            </div>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
