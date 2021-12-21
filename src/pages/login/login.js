$(() => {
    $("form").submit(function(e) {
        e.preventDefault();
        UserManager.login(
            $("#email").val(),
            $("#password").val()
        );
    });
})