<!DOCTYPE html>
<html>
<head>
    <title>Welcome to the {{ Str::title(str_replace('-', ' ', config('app.name')))}}Company</title>
</head>
<body>
    <h3>Welcome, {{ $data['name'] }}</h3>
    <p>Your account has been created successfully. Here are your login details:</p>
    <p>Email: {{ $data['email'] }}</p>
    <p>Password: {{ $password }}</p> 
    <p>The {{ Str::title(str_replace('-', ' ', config('app.name')))}} Team</p>
   
</body>
</html>
