@extends('layouts.two-columns')

@section('title', 'Home')

@section('content')
    <div class="card card-default">
        <div class="card-header">Single user
            <div class="actions float-right">
                <a href="{{route('users.edit', [$user->id])}}" class="btn btn-info btn-sm mr-2"><i class="fas fa-edit"></i> Edit</a>
                <a href="{{route('users.edit', [$user->id])}}" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Delete</a>
            </div>
        </div>
        <div class="card-body">
            <p><strong>ID :</strong> {{$user->id}}</p>
            <p><strong>Nom :</strong> {{$user->name}}</p>
            <p><strong>Téléphone :</strong> {{$user->phone}}</p>
            <p><strong>Garderie :</strong> {{optional($user->nursery)->name}}</p>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
