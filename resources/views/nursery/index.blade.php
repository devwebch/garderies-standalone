@extends('layouts.two-columns')

@section('title', 'Home')

@section('content')

    <h1>Nurseries</h1></span>

    <div class="actions mb-4">
        <a href="{{route('nurseries.create')}}" class="btn btn-primary btn-sm">Add nursery</a>
    </div>

    <nurseries></nurseries>
@endsection

@section('nav-lateral')
    @include('nursery.nav')
@endsection
