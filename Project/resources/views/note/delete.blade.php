<!DOCTYPE html>
<html>

<head>
    <title>Delete note {{ $note->id }} - {{ $note->title }}?</title>
</head>

<body>
    <p><a href="/notes?api_token={{ Auth::user()->api_token }}">Cancel</a></p>
    <h1>Confirm delete of note {{ $note->id }} - {{ $note->title }}?</h1>
    <p>Changes cannot be undone.</p>
    
    <form action="/api/notes/{{ $note->id }}/delete">
        <input type="hidden" name="api_token" value="{{ Auth::user()->api_token }}">
        <input type="hidden" name="redirect" value="1">
        <button type="submit">Delete</button>
    </form>
</body>

</html>