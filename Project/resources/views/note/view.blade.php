@extends('base')

@section('title', 'Note ' . $note->id . ' - ' . $note->title)

@section('content')
    <p>
        <a href="/notes/{{ $note->id }}/edit?api_token={{ Auth::user()->api_token }}" class="btn btn-primary">Edit</a>
        <a href="/notes/{{ $note->id }}/delete?api_token={{ Auth::user()->api_token }}" class="btn btn-outline-danger">Delete</a>
        <a href="/notes?api_token={{ Auth::user()->api_token }}" class="btn btn-secondary">Cancel</a>
    <h1>Note {{ $note->id }} - {{ $note->title }}</h1>
    
    <p>{{ $note->body }}</p>
@endsection