<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Tagazon</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
</head>

<body>

    <div id="login-div" hidden>
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
    </div>
    <div id="home-div" hidden>
        <h1 id="user-info-text"></h1>
        <input id="logout" type="submit" value="Logout">
    </div>

    <div id="container"></div>


    <script src="/tagazon/src/js/user-manager.js"></script>
    <script src="/tagazon/src/js/notifications-manager.js"></script>

    <script>
        $(() => {

            function userLogged() {
                if (UserManager.user["type"] == "buyer") {
                    NotificationsManager.start(UserManager.user["id"]);
                }
                $("#home-div").show();
                $("#login-div").hide();
                $("#user-info-text").text(`${UserManager.user["email"]} - ${UserManager.user["type"]}`);
            }

            function userNotLogged() {
                NotificationsManager.stop();
                $("#home-div").hide();
                $("#login-div").show();
            }

            UserManager.start(
                ifLogged = userLogged,
                ifNotLogged = userNotLogged
            );

            $("#login-form").submit(function(e) {
                e.preventDefault();
                UserManager.login(
                    $("#login-email").val(),
                    $("#login-password").val(),
                    () => {
                        userLogged();
                    }
                );
            });

            $("#register-form").submit(function(e) {
                e.preventDefault();
                UserManager.registerBuyer(
                    $("#register-email").val(),
                    $("#register-password").val(),
                    $("#register-name").val(),
                    $("#register-surname").val(),
                );
            });

            $("#logout").click(function(e) {
                UserManager.logout(() => {
                    userNotLogged()
                });
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
        });
    </script>

</body>

</html>