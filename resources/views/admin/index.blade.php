<!-- resources/views/dashboard/admin.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, Admin</h1>
    <ul>
        <li><a href="{{ route('admin.approve') }}">Approve Restaurants</a></li>
        <li><a href="{{ route('admin.ban') }}">Ban Restaurants</a></li>
    </ul>
</body>
</html>
