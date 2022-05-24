<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <!-- Meta -->
    <meta name="description" content="Login Dashboard PVMBG">
    <meta name="author" content="Martanto">
</head>
<body>
    <form action="{{ route('login.post') }}" method="post">
        @csrf
        <input name="username" type="text">
        <input name="password" type="password">
        <button type="submit">Submit</button>
    </form>
</body>
</html>
