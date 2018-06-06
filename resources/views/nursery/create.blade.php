@extends('layouts.two-columns')

@section('title', 'Créer une nursery')

@section('content')
    <div class="card card-default">
        <div class="card-header">Ajouter un établissement</div>
        <div class="card-body">
            <form action="{{route('nurseries.store')}}" method="post">
                {{csrf_field()}}
                {{method_field('POST')}}
                <div class="form-group">
                    <label for="name">Nom :</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="form-group">
                    <label for="name">Adresse :</label>
                    <input type="text" class="form-control" name="address">
                </div>
                <div class="row">
                    <div class="form-group col-3">
                        <label for="name">Code postal :</label>
                        <input type="text" class="form-control" name="post_code">
                    </div>
                    <div class="form-group col-9">
                        <label for="name">Ville :</label>
                        <input type="text" class="form-control" name="city">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="name">E-mail :</label>
                        <input type="text" class="form-control" name="email">
                    </div>
                    <div class="form-group col">
                        <label for="name">Téléphone :</label>
                        <input type="text" class="form-control" name="phone">
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
