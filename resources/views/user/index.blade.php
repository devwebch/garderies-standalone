@extends('layouts.two-columns')

@section('title', 'Users')

@section('content')

    <h1>Employees</h1>

    <div class="actions mb-4">
        <a href="#" class="btn btn-primary btn-sm">Add employee</a>
    </div>

    <users></users>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
