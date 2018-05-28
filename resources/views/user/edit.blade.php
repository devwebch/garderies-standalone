@extends('layouts.two-columns')

@section('title', 'Edition employé')

@section('content')
    <div class="card card-default">
        <div class="card-header">Edition employé</div>
        <div class="card-body">
            <form action="{{route('users.update', [$user->id])}}" method="post">
                {{csrf_field()}}
                {{method_field('PUT')}}

                <div class="form-group">
                    <label for="name">Nom :</label>
                    <input type="text" class="form-control" name="name" value="{{$user->name}}">
                </div>

                <div class="form-group">
                    <label for="email">E-mail :</label>
                    <input type="text" class="form-control" name="email" value="{{$user->email}}">
                </div>
                <div class="form-group">
                    <label for="phone">Téléphone :</label>
                    <input type="text" class="form-control" name="phone" value="{{$user->phone}}">
                </div>

                <div class="form-group">
                    <label for="nursery">Nursery:</label>
                    <select name="nursery" class="form-control">
                        <option value="0">Sélectionnez...</option>
                        @foreach($nurseries as $nursery)
                            <option value="{{$nursery->id}}" {{($nursery->id == ($user->nursery->id ?? 0)) ? 'selected' : ''}}>{{$nursery->name}}</option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-primary" type="submit">Enregistrer</button>
            </form>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
