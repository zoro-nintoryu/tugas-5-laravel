<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form method="POST" action="{{ url('/register') }}">
        @csrf
        <input type="text" name="name" placeholder="Name">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="password_confirmation" placeholder="Confirm Password">
        <select name="role">
            <option value="user">User</option>
            <option value="superadmin">Superadmin</option>
        </select>
        <button type="submit">Register</button>
    </form>
</body>
</html>
