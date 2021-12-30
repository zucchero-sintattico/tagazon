$(() => {
    $("form").submit(function(e) {
        e.preventDefault();
        Application.authManager.login(
            $("#email").val(),
            $("#password").val()
        );
    });
})