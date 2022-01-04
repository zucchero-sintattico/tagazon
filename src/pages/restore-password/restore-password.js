import { Application } from "../../res/js/application.js";
import { Page } from "../../res/js/page.js";


//Used to show an default error message whit text
function showErrorMessage(errorMessage) {
    $("body > main > section > footer > p").html(errorMessage);
    $("body > main > section > footer > p").fadeIn(500);
    $("body > main > section > form > fieldset > input[type='email']").addClass("error");
}
export class RestorePasswordPage extends Page {

    onPageLoad() {
        //Hide error message
        $("body > main > section > footer > p").hide();

        //Control submit button
        $("input[type='submit']").click(function(e) {
            e.preventDefault();
            Application.authManager.resetPassword(
                $("#email").val(),
                () => {
                    window.location.href = "?page=restore-password-success";
                },
                (err) => {
                    console.error(err);
                    showErrorMessage("Errore! L'email inserita non è valida");
                }
            );
        });
    }

}