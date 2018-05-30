@extends('layouts.two-columns')

@section('title', 'Edition réseau')

@section('content')
    <div class="card card-default">
        <div class="card-header">Edition réseau</div>
        <div class="card-body">
            <form action="{{route('networks.update', [$network->id])}}" method="post">
                {{csrf_field()}}
                {{method_field('PUT')}}
                <div class="form-group">
                    <label for="name">Nom :</label>
                    <input type="text" class="form-control" name="name" value="{{$network->name}}">
                </div>

                <button class="btn btn-primary" type="submit">Enregistrer</button>
            </form>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('nursery.nav')
@endsection
