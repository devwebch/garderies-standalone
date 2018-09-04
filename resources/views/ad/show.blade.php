@extends('layouts.naked')

@section('title', $ad->title)

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3>{{$ad->title}}</h3>
                    <p class="text-muted">{{$ad->created_at->format('d.m.Y')}}</p>
                    {{$ad->description}}
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-around mt-4">
        <div class="col-md-2 mb-2 mb-md-0">
            <a href="{{route('nurseries.ads', $ad->nursery)}}" class="btn btn-info btn-sm">Annonces de la garderie</a>
        </div>
        <div class="col-md-2 text-md-right">
            <form action="{{route('ads.destroy', $ad)}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
            </form>
        </div>
    </div>
@endsection

@section('nav-lateral')
    @include('network.nav')
@endsection