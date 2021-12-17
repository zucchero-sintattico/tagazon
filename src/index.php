<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Tagazon</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<?php session_start(); ?>

<?php if (!isset($_SESSION["user"])): ?>
    <form id="login-form" action="" method="post">
    <input type="email" name="email" id="login-email">
    <input type="password" name="password" id="login-password">
    <input type="submit" value="Login">
    </form>

    <p>Register</p>
    <form id="register-form" action="/tagazon/src/api/users/register/" method="post">
    <input type="email" name="email" id="register-email">
    <input type="password" name="password" id="register-password">
    <input type="text" name="name" id="register-name">
    <input type="text" name="surname" id="register-surname">
    <input type="submit" value="Register">
    </form>

<?php else: ?>
    <h1><?php echo $_SESSION["user"]["email"] . " -- " . $_SESSION["user"]["type"] ?></h1>
    <input id="logout" type="submit" value="Logout">
<?php endif; ?>

<div id="container"></div>
<script>

    function login(email, password, success=()=>{}, error=()=>{}) {
        $.ajax({
            url: "/tagazon/src/api/users/login/",
            type: "POST",
            data: {
                email: email,
                password: password
            },
            success: success,
            error: error
        });
    }

    function register(email, password, name, surname, success=()=>{}, error=()=>{}){
        $.ajax({
            url: "/tagazon/src/api/users/register/",
            type: "POST",
            data: {
                email: email,
                password: password,
                name: name,
                surname: surname
            },
            success: success, 
            error: error
        });
    }

    function logout(success=()=>{}, error=()=>{}){
        $.ajax({
            url: "/tagazon/src/api/users/logout/",
            type: "POST",
            success: success,
            error: error
        });
    }
    
    $("#login-form").submit(function(e){
        e.preventDefault();
        login(
            $("#login-email").val(), 
            $("#login-password").val(),
            success = (data) => {
                console.log(data);
                //window.location.reload();
            },
            error = (data) => {
                console.log(data);
            });     
    });

    $("#register-form").submit(function(e){
        e.preventDefault();
        register(
            $("#register-email").val(), 
            $("#register-password").val(),
            $("#register-name").val(),
            $("#register-surname").val(),
            success = (data) => {
                login(
                    $("#register-email").val(), 
                    $("#register-password").val(),
                    success = (data) => {
                        window.location.reload();
                    });
            });
             
    });

    $("#logout").click(function(e) {
        logout(
            success = () => {
                window.location.reload();
            }
        );   
    });
    
    $(() => {
        $.ajax({
                url: '/tagazon/src/api/tags/',
                success: (response) => {
                    response.data.forEach(element => {
                        $("#container").append(`<p>${element.name}</p>`);
                    });
                }
            });
    })



</script>
    
</body>
</html>