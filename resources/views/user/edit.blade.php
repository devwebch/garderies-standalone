@extends('layouts.two-columns')

@section('title', 'Edit')

@section('content')
    <div class="card card-default">
        <div class="card-header">Edit user</div>
        <div class="card-body">
            <form action="{{route('users.update', [$user->id])}}" method="post">
                {{csrf_field()}}
                {{method_field('PUT')}}

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" value="{{$user->name}}">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" name="email" value="{{$user->email}}">
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" name="phone" value="{{$user->phone}}">
                </div>

                <div class="form-group">
                    <label for="nursery">Nursery:</label>
                    <select name="nursery" class="form-control">
                        <option value="0">Select...</option>
                        @foreach($nurseries as $nursery)
                            <option value="{{$nursery->id}}" {{($nursery->id == ($user->nursery->id ?? 0)) ? 'selected' : ''}}>{{$nursery->name}}</option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
