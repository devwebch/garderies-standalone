@extends('layouts.two-columns')

@section('title', 'Users')

@section('content')
    <h1>Employees</h1>
    <users></users>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
