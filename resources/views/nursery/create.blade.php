@extends('layouts.app')

@section('title', 'Edit')

@section('content')
    <div class="card card-default">
        <div class="card-header">Create nursery</div>
        <div class="card-body">
            <form action="{{route('nurseries.store')}}" method="post">
                {{csrf_field()}}
                {{method_field('POST')}}
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name">
                </div>

                <button class="btn btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>
@endsection
