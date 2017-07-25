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
            initNotes(false);
            initModals();
        });
        
        function initModals() {
            var $noteNew = $("#note-new-modal");
            
            $noteNew.on("show.bs.modal", function(e) {
                var $content = $noteNew.find(".content-loadable");
                
                $content.LoadingOverlay("show", modal_LoadingOverlay);
                $content.load("/notes/new?" + $.param(app.forms.api_token), function() {
                    $content.LoadingOverlay("hide");
                });
            });
        }
        
        function initNotes(overlay) {
            if (typeof overlay == "undefined") overlay = true;
            
            var $notes = $("#notes-container");
            if (overlay) $notes.LoadingOverlay("show", {zIndex: 1000});
            
            $.get("/api/notes", app.forms.api_token, function(d) {
                //console.log("notes result: %o", d);
                
                // Hide overlay
                $notes.empty().LoadingOverlay("hide");
                
                // Add notes to app object
                app.notes = d.notes;
                
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
            //console.log("view note: %o", note);
            
            // Set up modal
            var $modal = $("#note-view-modal");
            var $content = $modal.find(".content-loadable");
            
            $content.LoadingOverlay("show", modal_LoadingOverlay);
            $content.load("/notes/" + note.id + "?" + $.param(app.forms.api_token), function() {
                $content.LoadingOverlay("hide");
            });
            
            // Display modal
            $modal.modal();
        }
        
        function editNote(note) {
            //console.log("edit note: %o", note);
            
            // Set up modal
            var $modal = $("#note-edit-modal");
            var $content = $modal.find(".content-loadable");
            
            $content.LoadingOverlay("show", modal_LoadingOverlay);
            $content.load("/notes/" + note.id + "/edit?" + $.param(app.forms.api_token), function() {
                $content.LoadingOverlay("hide");
            });
            
            // Display modal
            $modal.modal();
        }
        
        function deleteNote(note) {
            //console.log("delete note: %o", note);
            
            // Set up modal
            var $modal = $("#note-delete-modal");
            var $content = $modal.find(".content-loadable");
            
            $content.LoadingOverlay("show", modal_LoadingOverlay);
            $content.load("/notes/" + note.id + "/delete?" + $.param(app.forms.api_token), function() {
                $content.LoadingOverlay("hide");
            });
            
            // Display modal
            $modal.modal();
        }
    </script>
@endpush

@section('content')
    <h1>My Notes</h1>
    <p>
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#note-new-modal">New Note</a>
    </p>
    @if (!$notes)
        No notes!
    @else
        <div id="notes-container" class="card-columns">
            @php ($notes_count = Auth::user()->withCount('notes')->get()[0]->notes_count)
            
            @for ($i = 0; $i < $notes_count; ++$i)
                <div class="note-card card empty">
                    <div class="card-block">
                        <h4 class="card-title"><span class="badge badge-primary">note.title</span></h4>
                        <p class="note-body card-text"><span class="badge badge-default">note.body</span></p>
                        <p class="card-text"><small class="text-muted"><span class="badge badge-default">Created by <span class="note-created-by">user.name</span> on <span class="note-created-at">note.created_at</span></span></small></p>
                        <a href="#" class="note-btn-edit btn btn-sm btn-primary">Edit</a>
                        <a href="#" class="note-btn-delete btn btn-sm btn-outline-danger">Delete</a><br>
                    </div>
                </div>
            @endfor
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