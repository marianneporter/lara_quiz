<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <title>@yield('title')</title>
   
</head>
<body>
 
    <div>
        @yield('content')
    </div>

    <!-- Add your JavaScript links here -->
</body>
</html>
