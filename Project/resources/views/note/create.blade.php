<!DOCTYPE html>
<html>

<head>
    <title>New Note</title>
</head>

<body>
    <h1>New Note</h1>
    <p><a href="/notes?api_token={{ Auth::user()->api_token }}">Cancel</a></p>
    
    <form action="/api/notes/create">
        <input type="hidden" name="api_token" value="{{ Auth::user()->api_token }}">
        <input type="hidden" name="redirect" value="1">
        <p><label for="title">Title: <input type="text" name="title" id="title"></label></p>
        <p><label for="body">Body: <textarea name="body" id="body"></textarea></label></p>
        <button type="submit">Submit</button>
    </form>
</body>

</html>