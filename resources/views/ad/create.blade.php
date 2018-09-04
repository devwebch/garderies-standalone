@extends('layouts.two-columns')

@section('title', 'Création annonce')

@section('content')
    <ad-create inline-template>
        <div class="card card-default">
            <div class="card-header bg-dark text-white">{{$nursery->name}} - Ajout d'une annonce</div>
            <div class="card-body">
                <form action="{{route('ads.store', $nursery)}}" method="post">
                    {{csrf_field()}}
                    {{method_field('POST')}}

                    <input type="hidden" name="nursery" value="{{$nursery->id}}">
                    <div class="form-group">
                        <label for="name">Titre :</label>
                        <input type="text" class="form-control" name="title">
                    </div>
                    <div class="form-group">
                        <label for="description">Contenu :</label>
                        <textarea type="text" class="form-control" name="description" rows="10"></textarea>
                    </div>

                    <button class="btn btn-primary float-right" type="submit">Enregistrer</button>
                </form>
            </div>
        </div>
    </ad-create>
@endsection

@section('nav-lateral')
    @include('network.nav')
@endsection
