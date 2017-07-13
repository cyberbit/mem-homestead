@extends('base')

@section('title', 'My Notes')

@section('content')
    <h1>My Notes</h1>
    <p>
        <a href="/notes/new?api_token={{ Auth::user()->api_token }}" class="btn btn-primary">New Note</a>
    </p>
    @if (!$notes)
        No notes!
    @else
        <div class="card-columns">
            @foreach (Auth::user()->notes()->with('user')->get() as $note)
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title"><a href="/notes/{{ $note->id }}?api_token={{ Auth::user()->api_token }}">{{ $note->title }}</a></h4>
                        <p class="card-text">{{ $note->body }}</p>
                        <p class="card-text"><small class="text-muted">Created by {{ $note->user->name }} on {{ $note->created_at }}</small></p>
                        <a href="/notes/{{ $note->id }}/edit?api_token={{ Auth::user()->api_token }}" class="btn btn-sm btn-primary">Edit</a>
                        <a href="/notes/{{ $note->id }}/delete?api_token={{ Auth::user()->api_token }}" class="btn btn-sm btn-outline-danger">Delete</a><br>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection