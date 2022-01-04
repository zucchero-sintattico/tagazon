import { Application } from "../../res/js/application.js";
import { Page } from "../../res/js/page.js";

export class RegisterPage extends Page {

    onPageLoad() {

        $("section").load("./pages/register/cliente.html");
        $("section").fadeIn(500);

        $("input[type=radio]").on("change", function() {
            const val = $(this).val();
            $("section").fadeOut(500, function() {
                if (val === "cliente") {
                    $("section").load("./pages/register/cliente.html");
                } else {
                    $("section").load("./pages/register/venditore.html");
                }
                $("section").fadeIn(500);
            });
        });

        $("form").submit(function(e) {
            e.preventDefault();
            const type = $("input[type=radio]").val();
            if (type == "cliente") {
                Application.authManager.registerBuyer(
                    $("#email").val(),
                    $("#password").val(),
                    $("#nome").val(),
                    $("#cognome").val(),
                );
            } else {
                Application.authManager.registerSeller(
                    $("#email").val(),
                    $("#password").val(),
                    $("#rag_soc").val(),
                    $("#piva").val(),
                );
            }

        });
    }
}