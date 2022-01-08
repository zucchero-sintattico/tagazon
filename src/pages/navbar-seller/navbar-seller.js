import { Page } from '../../res/js/page.js';
import { SellerPage } from '../../res/js/seller-page.js';

export class NavbarSellerPage extends SellerPage {

    onPageLoad() {
        const page = new URLSearchParams(document.location.search).get("page");
        $(`#navbar-link-${page}`).addClass("active-page");
        $(`#navbar-link-${page}`).attr("href", "#");
    }

}