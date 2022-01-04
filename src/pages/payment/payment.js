import { Application } from "../../res/js/application.js";
import { Page } from "../../res/js/page.js";

export class PaymentPage extends Page {

    onPageLoad() {
        $("#expire-date").val(new Date());
    }
}