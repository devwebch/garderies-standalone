@extends('layouts.two-columns')

@section('title', 'Home')

@section('content')
    <nurseries></nurseries>
@endsection

@section('nav-lateral')
    @include('nursery.nav')
@endsection
