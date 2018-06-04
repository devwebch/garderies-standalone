@extends('layouts.two-columns')

@section('title', 'Employés')

@section('content')
    <users></users>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
