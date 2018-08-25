@extends('layouts.two-columns')

@section('title', 'Edition employé')

@section('content')
    <user-edit inline-template>
        <div class="card card-default">
            <div class="card-header">Edition employé</div>
            <div class="card-body">
                <form action="{{route('users.update', [$user->id])}}" method="post">
                    {{csrf_field()}}
                    {{method_field('PUT')}}

                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="name">Nom :</label>
                                <input type="text" class="form-control {{ ($errors->has('name')) ? 'is-invalid' : '' }}" name="name" value="{{$user->name}}">
                                @foreach ($errors->get('name') as $message)
                                    <div class="invalid-feedback" style="display: block;">
                                        Veuillez entrer le nom de l'employé.
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail :</label>
                                <input type="text" class="form-control {{ ($errors->has('email')) ? 'is-invalid' : '' }}" name="email" value="{{$user->email}}">
                                @foreach ($errors->get('email') as $message)
                                    <div class="invalid-feedback" style="display: block;">
                                        Veuillez entrer l'email de l'employé.
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label for="phone">Téléphone :</label>
                                <input type="text" class="form-control" name="phone" value="{{$user->phone}}" v-mask="'+41 ## ### ## ##'">
                            </div>

                            <div class="form-group">
                                <label for="nursery">Garderie :</label>
                                <select name="nursery" class="form-control selectpicker" title="Sélectionner..." data-live-search="true" data-style="btn-link border text-secondary">
                                    @foreach($nurseries as $nursery)
                                        <option value="{{$nursery->id}}" {{($nursery->id == ($user->nursery->id ?? 0)) ? 'selected' : ''}}>{{$nursery->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Réseaux :</label>
                                @foreach($managedNetworks as $network)
                                    <div class="form-check">
                                        <input type="checkbox" value="{{$network->id}}" class="form-check-input" id="network-{{$network->id}}" name="networks[]" {{(in_array($network->id, $currentNetworksKeys) ? 'checked' : '')}}>
                                        <label for="network-{{$network->id}}" class="form-check-label">{{$network->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label>Groupes de travail :</label>
                                @foreach($workgroups as $workgroup)
                                    <div class="form-check">
                                        <input type="checkbox" value="{{$workgroup->id}}" class="form-check-input" id="workgroup-{{$workgroup->id}}" name="workgroups[]" {{(in_array($workgroup->id, $currentWorkgroups) ? 'checked' : '')}}>
                                        <label for="workgroup-{{$workgroup->id}}" class="form-check-label">{{$workgroup->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label for="diploma">Diplôme :</label>
                                <select name="diploma" class="form-control selectpicker" title="Sélectionner..." data-style="btn-link border text-secondary">
                                    @foreach($diplomas as $diploma)
                                        <option value="{{$diploma->id}}" {{($diploma->id == $user->diploma->id) ? 'selected' : ''}}>{{$diploma->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
    
                    <a href="{{ route('users.show', $user) }}" class="btn btn-outline-primary btn-back">&larr; Retour</a>
                    <button class="btn btn-primary float-right" type="submit">Enregistrer</button>
                </form>
            </div>
        </div>
    </user-edit>
@endsection

@section('nav-lateral')
    @include('user.nav')
@endsection
