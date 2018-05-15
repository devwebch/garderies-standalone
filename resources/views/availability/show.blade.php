@extends('layouts.two-columns')

@section('title', 'Availability')

@section('content')
    <div class="card card-default">
        <div class="card-header">{{$availability->id}}
            <div class="actions float-right">
                <a href="{{route('availabilities.edit', [$availability->id])}}" class="btn btn-info btn-sm mr-2"><i class="fas fa-edit"></i> Edit</a>

                <div class="float-right">
                    <form action="{{route('availabilities.destroy', $availability->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Delete</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <p><strong>ID:</strong> {{$availability->id}}</p>
            <p><strong>Created at:</strong> {{$availability->created_at->format('d.m.Y - H:i')}}</p>
            <p><strong>Start:</strong> {{$availability->start}}</p>
            <p><strong>End:</strong> {{$availability->end}}</p>
        </div>
    </div>
@endsection

