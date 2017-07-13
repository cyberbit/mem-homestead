@extends('base')

@section('title', 'A notes manager')

@push('styles')
    <style>
        .home {
            text-align: center;
        }
        
        .lead {
            font-size: 1.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="home">
        <h1 class="display-1">Welcome to Mem!</h1>
        <p class="lead">
            This is where you should keep all your notes so you can re<strong>mem</strong>ber them. Get it? HAHAHAHAHA humor.
        </p>
    </div>
@endsection