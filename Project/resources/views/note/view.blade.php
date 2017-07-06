<!DOCTYPE html>
<html>

<head>
    <title>Note {{ $note->id }} - {{ $note->title }}</title>
</head>

<body>
    <p><a href="/notes?api_token={{ Auth::user()->api_token }}">Back to Notes</a></p>
    <a href="/notes/{{ $note->id }}/edit?api_token={{ Auth::user()->api_token }}">Edit</a> <a href="/notes/{{ $note->id }}/delete?api_token={{ Auth::user()->api_token }}">Delete</a>
    <h1>Note {{ $note->id }} - {{ $note->title }}</h1>
    
    <p>{{ $note->body }}</p>
</body>

</html>