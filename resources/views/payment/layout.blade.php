<!DOCTYPE html>
<html>
<head>
    <title>
        @yield('title')
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" rel="stylesheet">
    @yield('meta')
</head>
<body>
    <div class="container mt-5">
        <div class="mt-5"></div>
        @yield('content')
    </div>
    @yield('scripts')
</body>
</html>
