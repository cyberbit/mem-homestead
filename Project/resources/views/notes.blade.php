<!DOCTYPE html>
<html>

<head>
    <title>My Notes</title>
</head>

<body>
    <h1>My Notes</h1>
    
    <a href="/notes/new?api_token={{ Auth::user()->api_token }}">New Note</a> <a href="/logout?api_token={{ Auth::user()->api_token }}">Logout</a>
    @if (!$notes)
        No notes!
    @else
        <ul>
            @foreach (Auth::user()->notes()->with('user')->get() as $note)
                <li>
                    <strong><a href="/notes/{{ $note->id }}?api_token={{ Auth::user()->api_token }}">{{ $note->title }}</a></strong> <em>(Created by {{ $note->user->name }} on {{ $note->created_at }})</em> <a href="/notes/{{ $note->id }}/edit?api_token={{ Auth::user()->api_token }}">Edit</a> <a href="/notes/{{ $note->id }}/delete?api_token={{ Auth::user()->api_token }}">Delete</a><br>
                    {{ $note->body }}
                </li>
            @endforeach
        </ul>
    @endif
</body>

</html>