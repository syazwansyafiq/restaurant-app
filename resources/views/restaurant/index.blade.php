<!DOCTYPE html>
<html>
<head>
    <title>Manager Dashboard</title>
</head>
<body>
    <h1>Welcome, Restaurant Manager</h1>
    <ul>
        <li><a href="{{ route('manager.orders') }}">Manage Orders</a></li>
        <li><a href="{{ route('manager.sales') }}">View Sales</a></li>
    </ul>
</body>
</html>
