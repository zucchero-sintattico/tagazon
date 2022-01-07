import { Application } from "../../res/js/application.js";
import { Page } from "../../res/js/page.js";

export class PaymentPage extends Page {

    onCartChange() {

        $("#submit").val(`Paga (${Application.cart.getTotalPrice().toFixed(2)}€)`);
        $("#submit").click((e) => {
            e.preventDefault();

            window.location.href = "?page=order-completed";
        });
    }
}