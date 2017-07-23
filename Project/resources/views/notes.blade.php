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
            
            initNotes(false);
            initModals();
            
            function initNotes(overlay) {
                if (typeof overlay == "undefined") overlay = true;
                
                var $notes = $("#notes-container");
                if (overlay) $notes.LoadingOverlay("show", {zIndex: 1000});
                
                $.get("/api/notes", {api_token: app.user.api_token}, function(d) {
                    console.log("notes result: %o", d);
                    
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
            
            function initModals() {
                var $noteEdit = $("#note-edit-modal");
                var $noteNew = $("#note-new-modal");
                
                $noteEdit.find("form").submit(function(e) {
                    e.preventDefault();
                    
                    var note = $noteEdit.data("note");
                    var formData = [{name: "api_token", value: app.user.api_token}];
                    
                    console.log("update note: %o", note);
                    
                    var $submit = $(this).find("[type=submit]");
                    $submit.attr("disabled", true);
                    
                    // Submit form
                    $.get("/api/notes/" + note.id + "/update", $.merge(formData, $(this).serializeArray()), function(d) {
                        console.log("update result: %o", d);
                        
                        $submit.attr("disabled", false);
                        
                        if (d.status == "success") {
                            // Close modal and refresh notes
                            $noteEdit.modal('hide');
                            initNotes();
                        }
                        
                        else {
                            $submit.removeClass("btn-primary").addClass("btn-danger");
                            $submit.text("Error!");
                            
                            setTimeout(function() {
                                $submit.removeClass("btn-danger").addClass("btn-primary");
                                $submit.text("Submit");
                            }, 1700);
                        }
                    });
                });
                
                // Capture "New Note" button
                $noteNew.on("show.bs.modal", function(e) {
                    console.log("new note");
                    
                    // Determine next note ID
                    var newID = Math.max.apply(Math, app.notes.map(function(o) { return o.id; })) + 1;
                    
                    // Set up modal
                    var $modal = $(this);
                    $modal.find("[name=title]").val("new note " + newID);
                });
                
                $noteNew.find("form").submit(function(e) {
                    e.preventDefault();
                    
                    var formData = [{name: "api_token", value: app.user.api_token}];
                    
                    console.log("create note");
                    
                    var $submit = $(this).find("[type=submit]");
                    $submit.attr("disabled", true);
                    
                    // Submit form
                    $.get("/api/notes/create", $.merge(formData, $(this).serializeArray()), function(d) {
                        console.log("create result: %o", d);
                        
                        $submit.attr("disabled", false);
                        
                        if (d.status == "success") {
                            // Close modal and refresh notes
                            $noteNew.modal('hide');
                            initNotes();
                        }
                        
                        else {
                            $submit.removeCLass("btn-primary").addClass("btn-danger");
                            $submit.text("Error!");
                            
                            setTimeout(function() {
                                $submit.removeCLass("btn-danger").addClass("btn-primary");
                                $submit.text("Submit");
                            }, 1700);
                        }
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
                $modal.find(".note-updated-at").text(note.updated_at);
                
                // Display modal
                $modal.modal();
            }
            
            function editNote(note) {
                console.log("edit note: %o", note);
                
                // Set up modal
                var $modal = $("#note-edit-modal").data("note", note);
                $modal.find("[name=title]").val(note.title);
                $modal.find("[name=body]").val(note.body);
                
                // Display modal
                $modal.modal();
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