@extends('layouts.two-columns')

@section('title', 'Edit')

@section('content')
    <div class="card card-default">
        <div class="card-header">Edit nursery</div>
        <div class="card-body">
            <form action="{{route('nurseries.update', [$nursery->id])}}" method="post">
                {{csrf_field()}}
                {{method_field('PUT')}}
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" value="{{$nursery->name}}">
                </div>

                <button class="btn btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('nursery.nav')
@endsection
