@extends('layouts.two-columns')

@section('title', 'Home')

@section('content')
    <h1>Nurseries</h1>
    <nurseries></nurseries>
@endsection

@section('nav-lateral')
    @include('nursery.nav')
@endsection
