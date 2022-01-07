import { Application } from "../../res/js/application.js";
import { NavbarPage } from '../navbar/navbar.js';

export class ProfilePage extends NavbarPage {

    onUserLoad() {
        $("h1").text(`Profile - ${Application.user.getAlias()}`);
    }

}