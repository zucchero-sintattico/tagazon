import { Page } from '../../res/js/page.js';
import { Application } from '../../res/js/application.js';

export class NavbarPage extends Page {

    onPageLoad() {
        const page = new URLSearchParams(document.location.search).get("page");
        $(`#navbar-link-${page}`).addClass("active-page");
        $(`#navbar-link-${page}`).attr("href", "#");
    }

    onCartChange() {
        if (Application.cart.getTotalQuantity() > 0) {
            $("#navbar-cart-items-counter").text(Application.cart.getTotalQuantity());
            $("#navbar-cart-items-counter").fadeIn(500);
        } else {
            $("#navbar-cart-items-counter").hide();
        }
    }

    onNotificationsChange() {
        const unseen = Application.notifications.filter(notification => !notification.getSeen()).length;
        if (unseen > 0) {
            $("#navbar-notifications-counter").text(unseen);
            $("#navbar-notifications-counter").fadeIn(500);
        } else {
            $("#navbar-notifications-counter").hide();
        }
    }
}