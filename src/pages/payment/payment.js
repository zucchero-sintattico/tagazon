import { Application } from "../../res/js/application.js";
import { Page } from "../../res/js/page.js";

export class PaymentPage extends Page {

    onCartChange() {

        $("#submit").val(`Paga (${Application.cart.getTotalPrice().toFixed(2)}€)`);
        $("form").submit((e) => {
            e.preventDefault();
            $.ajax({
                url: "/tagazon/src/api/objects/orders/",
                method: "POST",
                success: (data) => {
                    window.location.href = "?page=order-completed";
                }

            });


        });
    }
}