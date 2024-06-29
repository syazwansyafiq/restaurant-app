<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
</head>
<body>
    <h1>Welcome, Customer</h1>
    <ul>
        <li><a href="{{ route('customer.orders') }}">View Orders</a></li>
        <li><a href="{{ route('customer.loyalty') }}">Loyalty Points</a></li>
    </ul>
</body>
</html>
