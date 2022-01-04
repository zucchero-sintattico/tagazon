import { Page } from "../../res/js/page.js";
import { Application } from "../../res/js/application.js";
export class ProfilePage extends Page {

    onPageLoad() {
        const user = Application.user;
        $("h1").text(`Bentornato ${user.getName()}`)
    }

}