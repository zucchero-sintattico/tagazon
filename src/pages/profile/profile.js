import { Application } from "../../res/js/application.js";
import { NavbarPage } from '../navbar/navbar.js';

export class ProfilePage extends NavbarPage {

    onUserLoad() {
        $("h1").text(`Profile - ${Application.user.getAlias()}`);
    }

    onUserLoad() {

        $("h1").text(`Bentornato ${Application.user.getName()}`)

        $("#logout").click(() => {
            Application.authManager.logout(() => {
                window.location.href = "?page=login";
            });
        });


        $("#change-password").click(() => {
            $("#change-password-popup").fadeIn(300);
        });

        $("#dismiss").click(() => {
            $("#change-password-popup").fadeOut(300);
        });

        $("#change-password-form").click(() => {
            if ($("#error").is(":visible")) {
                $("#error").hide(200);
            }
        });

        $("#change-password-form").submit((e) => {
            e.preventDefault();
            let oldPassword = $("#old-password").val();
            let newPassword = $("#new-password").val();
            let confirmPassword = $("#confirm-password").val();

            if (newPassword != confirmPassword) {
                $("#error").text("Passwords do not match");
                $("#error").show(500);
                return;
            }

            Application.authManager.changePassword(oldPassword, newPassword, (data) => {
                console.log(data);
                $("#error").hide(0);
                $("#change-password-popup").fadeOut(300);
                $("#box").fadeIn(200);
            }, (data) => {
                console.log(data);
                $("#error").text("Password isn't correct");
                $("#error").show(500);
            });
        });

        $(".close").click(() => {
            $("#box").fadeOut(200);
        });

    }

}