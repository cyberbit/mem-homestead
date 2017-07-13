@extends('base')

@section('title', 'New Note')

@section('content')
    <h1>New Note</h1>
    
    <form action="/api/notes/create">
        <input type="hidden" name="api_token" value="{{ Auth::user()->api_token }}">
        <input type="hidden" name="redirect" value="1">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="new note">
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <textarea name="body" id="body" class="form-control" placeholder="Body"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/notes?api_token={{ Auth::user()->api_token }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection