@extends('layouts.two-columns')

@section('title', 'Disponibilités')

@section('content')
    <div class="card card-default">
        <div class="card-header">{{$user->name}}</div>
        <div class="card-body">
            <user-availabilities user="{{$user->id}}"></user-availabilities>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
