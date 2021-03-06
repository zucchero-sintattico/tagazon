import { Application } from "../../res/js/application.js";
import { NavbarSellerPage } from '../navbar-seller/navbar-seller.js';

export class SellerProfilePage extends NavbarSellerPage {

    onUserLoad() {

        $("h1").text(`Profile - ${Application.user.getRagSoc()}`);
        $("#balance").text(`Your balance: `);

        $.ajax({
            url: "/tagazon/src/api/users/info/balance/",
            type: "GET",
            success: (response) => {
                $("#balance").text(`Your balance: ${response.data.toFixed(2)}€`);
            }
        });

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

        $("#close").click(() => {
            $("#box").fadeOut(200);
        });

    }

}