import { Application } from "../../res/js/application.js";
import { Page } from "../../res/js/page.js";

export class RestorePasswordSuccessPage extends Page {
    onPageLoad() {
        $("body > main > section > button").click(function() {
            window.location.href = "?page=login";
        });
    }
}