@extends('layouts.two-columns')

@section('title', $user->name)

@section('content')
    <div class="card card-default">
        <div class="card-header">{{$user->id}} - {{$user->name}}</div>
        <div class="card-body">
            <user-availabilities></user-availabilities>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
