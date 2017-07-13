@extends('base')

@section('title', 'Delete note ' . $note->id . ' - ' . $note->title . '?')

@section('content')
    <h1>Confirm delete of note {{ $note->id }} - {{ $note->title }}?</h1>
    <p>Changes cannot be undone.</p>
    
    <form action="/api/notes/{{ $note->id }}/delete">
        <input type="hidden" name="api_token" value="{{ Auth::user()->api_token }}">
        <input type="hidden" name="redirect" value="1">
        
        <button type="submit" class="btn btn-danger">Delete</button>
        <a href="/notes?api_token={{ Auth::user()->api_token }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection