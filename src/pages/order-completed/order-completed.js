import { Page } from "../../res/js/page.js";

export class OrderCompletedPage extends Page {

    onPageLoad() {

        $("body > main > section > button").click(function() {
            window.location.href = "?page=home";
        });

    }

}