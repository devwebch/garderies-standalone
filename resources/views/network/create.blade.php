@extends('layouts.two-columns')

@section('title', 'Création réseau')

@section('content')
    <div class="card card-default">
        <div class="card-header">Création réseau</div>
        <div class="card-body">
            <form action="{{route('networks.store')}}" method="post">
                {{csrf_field()}}
                {{method_field('POST')}}
                <div class="form-group">
                    <label for="name">Nom :</label>
                    <input type="text" class="form-control" name="name">
                </div>

                <button class="btn btn-primary" type="submit">Enregistrer</button>
            </form>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('nursery.nav')
@endsection
