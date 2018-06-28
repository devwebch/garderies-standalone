@extends('layouts.two-columns')

@section('title', 'Edition Etablissement')

@section('content')
    <div class="card card-default">
        <div class="card-header">Edition établissement</div>
        <div class="card-body">
            <form action="{{route('nurseries.update', [$nursery->id])}}" method="post">
                {{csrf_field()}}
                {{method_field('PUT')}}
                <div class="form-group">
                    <label for="name">Nom :</label>
                    <input type="text" class="form-control" name="name" value="{{$nursery->name}}">
                </div>
                <div class="form-group">
                    <label for="name">Adresse :</label>
                    <input type="text" class="form-control" name="address" value="{{$nursery->address}}">
                </div>
                <div class="row">
                    <div class="form-group col-3">
                        <label for="name">Code postal :</label>
                        <input type="text" class="form-control" name="post_code" value="{{$nursery->post_code}}">
                    </div>
                    <div class="form-group col-9">
                        <label for="name">Ville :</label>
                        <input type="text" class="form-control" name="city" value="{{$nursery->city}}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="name">E-mail :</label>
                        <input type="text" class="form-control" name="email" value="{{$nursery->email}}">
                    </div>
                    <div class="form-group col">
                        <label for="name">Téléphone :</label>
                        <input type="text" class="form-control" name="phone" value="{{$nursery->phone}}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="network">Réseau :</label>
                        <select name="network" class="form-control">
                            <option value="">Sélectionner...</option>
                            @foreach($networks as $network)
                                <option value="{{$network->id}}" {{(optional($nursery->network)->id == $network->id) ? 'selected' : ''}}>{{$network->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Enregistrer</button>
            </form>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('nursery.nav')
@endsection
