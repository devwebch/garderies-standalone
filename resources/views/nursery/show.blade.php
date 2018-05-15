@extends('layouts.two-columns')

@section('title', 'Home')

@section('content')
    <div class="card card-default">
        <div class="card-header">{{$nursery->name}}
            <div class="actions float-right">
                <a href="{{route('nurseries.edit', [$nursery->id])}}" class="btn btn-info btn-sm mr-2"><i class="fas fa-edit"></i> Edit</a>

                <div class="float-right">
                    <form action="{{route('nurseries.destroy', $nursery->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Delete</button>
                    </form>
                </div>
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

            <h3>Bookings</h3>

            <table class="table">
                <thead>
                <tr>
                    <th>Employé</th>
                    <th>Remplaçant</th>
                    <th>Garderie</th>
                    <th>Début</th>
                    <th>Fin</th>
                </tr>
                </thead>
                @forelse($bookings as $booking)
                    <tr>
                        <td><a href="{{route('users.show', $booking->user->id)}}">{{$booking->user->name}}</a></td>
                        <td><a href="{{route('users.show', $booking->substitute->id)}}">{{$booking->substitute->name}}</a></td>
                        <td><a href="{{route('nurseries.show', $booking->nursery->id)}}">{{$booking->nursery->name}}</a></td>
                        <td>{{\Carbon\Carbon::parse($booking->start)->format('d.m.Y H:i')}}</td>
                        <td>{{\Carbon\Carbon::parse($booking->end)->format('d.m.Y H:i')}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Pas de remplacement</td>
                    </tr>
                @endforelse
            </table>

        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('nursery.nav')
@endsection
