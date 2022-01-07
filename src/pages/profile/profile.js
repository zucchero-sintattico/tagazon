import { Application } from "../../res/js/application.js";
import { NavbarPage } from '../navbar/navbar.js';

export class ProfilePage extends NavbarPage {

    onUserLoad() {
        $("h1").text(`Profile - ${Application.user.getAlias()}`);
    }

    onPageLoad() {
        $("#logout").on("click", () => {
            document.cookie = "PHPSESSID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        });
    }

}