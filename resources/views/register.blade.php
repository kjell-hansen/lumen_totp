<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register new user</title>
    <style>
        label {
            display: block;
            padding: 10px 0;
        }
    </style>
</head>
<body>
<h1>Register user</h1>
@if($message!=='')
    <p>{{$message}}</p>
@endif
<form method="post">
    <label>Namn: <input type="text" name="name" placeholder="Enter your name"></label>
    <label>Email: <input type="email" name="email" placeholder="Enter your email"></label>
    <input type="submit" value="Register">
</form>
</body>
</html>
