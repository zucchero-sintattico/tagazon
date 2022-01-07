import { Page } from "../../res/js/page.js";
import { Application } from "../../res/js/application.js";
export class ProfilePage extends Page {

    onUserLoad() {

        $("h1").text(`Bentornato ${Application.user.getName()}`)

        $("#logout").click(() => {
            Application.authManager.logout(() => {
                window.location.href = "?page=login";
            });
        });
    }

}