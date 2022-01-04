import { Page } from '../res/js/page.js';
import { Application } from '../res/js/application.js';

export class NavbarPage extends Page {

    onPageLoad() {
        const page = new URLSearchParams(document.location.search).get("page");
        $(`#${page}`).addClass("active-page");
    }

    onCartChange() {
        if (Application.cart.getTotalQuantity() > 0) {
            $("#cart-counter").text(Application.cart.getTotalQuantity());
            $("#cart-counter").fadeIn(500);
        } else {
            $("#cart-counter").hide();
        }
    }

    onNotificationsChange() {
        const unseen = Application.notifications.filter(notification => !notification.getSeen()).length;
        if (unseen > 0) {
            $("#notification-counter").text(unseen);
            $("#notification-counter").fadeIn(500);
        } else {
            $("#notification-counter").hide();
        }
    }
}