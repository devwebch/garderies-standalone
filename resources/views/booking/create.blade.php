@extends('layouts.two-columns')

@section('title', 'Créer')

@section('content')
    <booking-create inline-template>
        <div class="card card-default">
            <div class="card-header">Créer remplaçement</div>
            <div class="card-body">
                <form action="{{route('bookings.store')}}" method="post">
                    {{csrf_field()}}
                    {{method_field('POST')}}
                    <div class="row">
                        <div class="form-group col">
                            <label for="user">Employé :</label>
                            <select name="user" class="form-control">
                                <option value="">Sélectionner...</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col">
                            <label for="substitute">Remplaçant :</label>
                            <select name="substitute" class="form-control">
                                <option value="">Sélectionner...</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="nursery">Garderie</label>
                            <select name="nursery" class="form-control">
                                <option value="">Sélectionner...</option>
                                @foreach($nurseries as $nursery)
                                    <option value="{{$nursery->id}}">{{$nursery->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="name">Début :</label>
                            <flat-pickr
                                    :config="flatPickrConfig"
                                    value="{{now()->addHours(2)->format('d.m.Y H:00')}}"
                                    class="form-control"
                                    placeholder="Select a date"
                                    name="date_start">
                            </flat-pickr>
                        </div>
                        <div class="form-group col">
                            <label for="name">Fin :</label>
                            <flat-pickr
                                    :config="flatPickrConfig"
                                    value="{{now()->addHours(6)->format('d.m.Y H:00')}}"
                                    class="form-control"
                                    placeholder="Select a date"
                                    name="date_end">
                            </flat-pickr>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Enregistrer</button>
                </form>
            </div>
        </div>
    </booking-create>
@endsection

@section('nav-lateral')
    @include('booking.nav')
@endsection
