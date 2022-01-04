import { Page } from "../../res/js/page.js";
import { Application } from "../../res/js/application.js";
export class ProfilePage extends Page {

    onPageLoad() {
        $("h1").text(`Bentornato ${Application.user.getName()}`)
    }

}