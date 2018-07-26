@extends('layouts.two-columns')

@section('title', 'Création réseau')

@section('content')
    <div class="row">
        <div class="col mb-2">
            <a href="{{ url()->previous() }}" class="btn btn-info btn-sm">&larr; Retour</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <network-create inline-template>
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
                            <div class="form-group">
                                <label for="color">Couleur :</label>
                                <input type="hidden" name="color" :value="color">
                                <swatches v-model="color" colors="material-basic" shapes="circles" popover-to="right" row-length="6" inline></swatches>
                            </div>
                    
                            <button class="btn btn-primary" type="submit">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </network-create>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('network.nav')
@endsection
