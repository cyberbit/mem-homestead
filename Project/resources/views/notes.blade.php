@extends('base')

@section('title', 'My Notes')

@push('styles')
    <style>
        @media (max-width: 991px) and (min-width: 576px) {
            .card-columns {
                column-count: 2;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(function() {
            var defaultApiData = {
                api_token: app.user.api_token
            };
            
            initNotes();
            
            function initNotes() {
                var $notes = $("#notes-container");
                
                $.get("api/notes", {api_token: app.user.api_token}, function(d) {
                    console.log("notes result: %o", d);
                    
                    // Iterate notes
                    $.each(d.notes, function(i, v) {
                        var $note = _factory("note-card");
                        
                        // Set up note
                        $note.find(".note-title").text(v.title).click(function(e) {
                            e.preventDefault();
                            
                            viewNote(v);
                        });
                        $note.find(".note-body").text(v.body);
                        $note.find(".note-created-by").text(v.user.name);
                        $note.find(".note-created-at").text(v.created_at);
                        $note.find(".note-btn-edit").click(function(e) {
                            e.preventDefault();
                            
                            editNote(v);
                        });
                        $note.find(".note-btn-delete").click(function(e) {
                            e.preventDefault();
                            
                            deleteNote(v);
                        });
                        
                        // Append note to container
                        $notes.append($note);
                    });
                });
            }
            
            function viewNote(note) {
                console.log("view note: %o", note);
                
                // Set up modal
                var $modal = $("#note-view-modal");
                $modal.find(".note-title").text(note.title);
                $modal.find(".note-body").text(note.body);
                $modal.find(".note-created-by").text(note.user.name);
                $modal.find(".note-created-at").text(note.created_at);
                $modal.find(".note-updated-at").text(moment(note.updated_at).fromNow());
                
                $("#note-view-modal").modal();
            }
            
            function editNote(note) {
                console.log("edit note: %o", note);
            }
            
            function deleteNote(note) {
                console.log("delete note: %o", note);
            }
        });
    </script>
@endpush

@section('content')
    <h1>My Notes</h1>
    <p>
        <a href="/notes/new?api_token={{ Auth::user()->api_token }}" class="btn btn-primary">New Note</a>
    </p>
    @if (!$notes)
        No notes!
    @else
        <div id="notes-container" class="card-columns">
            {{-- @foreach (Auth::user()->notes()->with('user')->get() as $note)
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title"><a href="/notes/{{ $note->id }}?api_token={{ Auth::user()->api_token }}">{{ $note->title }}</a></h4>
                        <p class="card-text">{{ $note->body }}</p>
                        <p class="card-text"><small class="text-muted">Created by {{ $note->user->name }} on {{ $note->created_at }}</small></p>
                        <a href="/notes/{{ $note->id }}/edit?api_token={{ Auth::user()->api_token }}" class="btn btn-sm btn-primary">Edit</a>
                        <a href="/notes/{{ $note->id }}/delete?api_token={{ Auth::user()->api_token }}" class="btn btn-sm btn-outline-danger">Delete</a><br>
                    </div>
                </div>
            @endforeach --}}
        </div>
    @endif
@endsection