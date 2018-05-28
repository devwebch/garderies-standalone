@extends('layouts.two-columns')

@section('title', 'Employés')

@section('content')
    <h1>Employés</h1>
    <users></users>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
