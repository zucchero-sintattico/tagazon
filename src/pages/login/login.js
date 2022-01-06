import { Application } from "../../res/js/application.js";
import { Page } from "../../res/js/page.js";

export class LoginPage extends Page {

    onPageLoad() {
        $("form").submit(function(e) {
            e.preventDefault();
            Application.authManager.login(
                $("#email").val(),
                $("#password").val(),
                () => window.location.reload(),
                () => { $("#error").toggle(500).delay(5000).toggle(500); }
            );
        });
    }
}