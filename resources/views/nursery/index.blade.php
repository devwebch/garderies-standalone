@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="actions text-right mb-4">
        <a href="{{route('nurseries.create')}}" class="btn btn-primary">Create nursery</a>
    </div>
    <nurseries></nurseries>
@endsection
