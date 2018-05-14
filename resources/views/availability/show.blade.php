@extends('layouts.two-columns')

@section('title', 'Availability')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            {{$availability->id}}
        </div>

        <div class="card-body">
            <p><strong>ID:</strong> {{$availability->id}}</p>
            <p><strong>Created at:</strong> {{$availability->created_at->format('d.m.Y - H:i')}}</p>
            <p><strong>Start:</strong> {{$availability->start}}</p>
            <p><strong>End:</strong> {{$availability->end}}</p>
        </div>
    </div>
@endsection

