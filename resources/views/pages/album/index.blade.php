@extends('layout.master')
@section('navbar-sidebar')
    @include('component._navbar')
    @include('component._sidebar')
@endsection
@section('content')
    <h1 class="text-center text-dark">{{ $title }}</h1>
    <div class="sticky-top row justify-content-center" style="top: 20px; z-index: 40">
        <div class="col-md-10">
            <form action="{{ route('album.index') }}" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search.." name="search"
                        value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                    <form>
                </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            @foreach ($albums as $album)
                <div class="col-md-4 mb-3">
                    <div class="card" style="height: 460px">
                        <a href="{{ route('album.show', $album->id) }}">
                        <img class="card-img-top" src="{{ asset('images/album/' . $album['thumbnail']) }}"
                            alt="Card image cap" style="height: 300px; ">
                        </a>
                        <div class="card-body">
                            <strong class="card-title">{{ $album->name }}</strong>
                        @if (strlen($album->description) > 100)
                            <p class="card-text">{{ substr($album->description, 0, 100) }}... <a href="{{ route('album.show', $album->id) }}">Read More</a></p>
                        @else
                            <p class="card-text">{{ $album->description }}</p>
                        @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
