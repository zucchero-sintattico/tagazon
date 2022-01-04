import { NavbarPage } from '../navbar/navbar.js';
import { Application } from '../../res/js/application.js';

export class InfoTagPage extends NavbarPage {

    onPageLoad() {
        const tagId = new URLSearchParams(document.location.search).get("tagId");

    }

}