<!DOCTYPE html>
<html>

<head>
    <title>Mem - Login</title>
</head>

<body>
    <h1>Login to Mem</h1>
    <form action="/api/login">
        <input type="hidden" name="redirect" value="1">
        <label for="email">Email: <input type="text" id="email" name="email"></label>
        <label for="password">Password: <input type="password" id="password" name="password"></label>
        <button type="submit">Submit</button>
    </form>
</body>

</html>