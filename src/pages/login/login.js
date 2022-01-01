class LoginPage extends Page {

    onPageLoad() {
        $("form").submit(function(e) {
            e.preventDefault();
            Application.authManager.login(
                $("#email").val(),
                $("#password").val()
            );
        });
    }
}