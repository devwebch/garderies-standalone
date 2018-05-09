@extends('layouts.two-columns')

@section('title', 'Home')

@section('content')
    <div class="card card-default">
        <div class="card-header">{{$nursery->name}}
            <div class="actions float-right">
                <a href="{{route('nurseries.edit', [$nursery->id])}}" class="btn btn-info btn-sm mr-2"><i class="fas fa-edit"></i> Edit</a>
                <a href="{{route('nurseries.edit', [$nursery->id])}}" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Delete</a>
            </div>
        </div>

        <div class="card-body">
            <p><strong>ID:</strong> {{$nursery->id}}</p>
            <p><strong>Name:</strong> {{$nursery->name}}</p>

            <p><strong>Employés: </strong> {{$nursery->users->count()}}</p>
            @if( $nursery->users->count() )
            <ul>
                @foreach( $nursery->users as $user )
                <li>{{$user->name}}</li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('nursery.nav')
@endsection
