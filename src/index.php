<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Tagazon</title>
</head>
<body>
<?php session_start(); ?>

<?php if (!isset($_SESSION["email"])): ?>
    <form action="/tagazon/src/api/users/login/" method="post">
    <input type="email" name="email" id="">
    <input type="password" name="password" id="">
    <input type="submit" value="Login">
    </form>

    <p>Register</p>
    <form action="/tagazon/src/api/users/register/" method="post">
    <input type="email" name="email" id="">
    <input type="password" name="password" id="">
    <input type="text" name="name" id="">
    <input type="text" name="surname" id="">
    <input type="submit" value="Register">
    </form>
<?php else: ?>
    <h1><?php echo $_SESSION["email"] . " -- " . $_SESSION["type"]?></h1>
    <form action="/tagazon/src/api/users/logout/" method="post">
        <input type="submit" value="Logout">
    </form>
<?php endif; ?>

    
</body>
</html>