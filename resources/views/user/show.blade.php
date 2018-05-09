@extends('layouts.two-columns')

@section('title', $user->name)

@section('content')
    <div class="card card-default">
        <div class="card-header">{{$user->id}} - {{$user->name}}
            <div class="actions float-right">
                <a href="{{route('users.edit', [$user->id])}}" class="btn btn-info btn-sm mr-2"><i class="fas fa-edit"></i> Edit</a>
                <a href="{{route('users.edit', [$user->id])}}" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Delete</a>
            </div>
        </div>
        <div class="card-body">
            <p><strong>Nom :</strong> {{$user->name}}</p>
            <p><strong>E-mail :</strong> {{$user->email}}</p>
            <p><strong>Téléphone :</strong> {{$user->phone}}</p>
            <p><strong>Garderie :</strong> {{$user->nursery->name ?? '-'}}</p>

            <h3>Availabilities</h3>
            <ul>
                @foreach($availabilities as $slot)
                    <li>{{$slot->start}} - {{$slot->end}}</li>
                @endforeach
            </ul>


            <p><a href="{{route('users.availabilities', $user->id)}}" class="btn btn-info"><i class="fas fa-calendar"></i> Availabilities</a></p>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
