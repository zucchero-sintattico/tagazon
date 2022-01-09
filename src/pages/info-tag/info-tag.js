import { NavbarPage } from '../navbar/navbar.js';
import { Application } from '../../res/js/application.js';

export class InfoTagPage extends NavbarPage {


    encodeStr(str) {
        return str.replace(/[\u00A0-\u9999<>\&]/g, function(i) {
            return '&#' + i.charCodeAt(0) + ';';
        });
    };

    onPageLoad() {
        const tagId = new URLSearchParams(document.location.search).get("tag_id");
        const _this = this;
        $.ajax({
            url: `/tagazon/src/api/objects/tags/?id=${tagId}`,
            type: "GET",
            success: (response) => {

                const { data } = response;
                const tag = data[0];
                $("#info-tag-name").text(tag.name);
                $("#subinfo-tag-name").text(tag.name);
                $("#info-tag-description").text(tag.description);
                $("#info-tag-price").text((tag.sale_price !== null ? tag.sale_price : tag.price) + "€");
                $("#info-tag-example-desc").text(tag.example_desc);
                $("#info-tag-example").text(tag.example);
                hljs.highlightElement(document.getElementById("info-tag-example"));

                $.ajax({
                    url: `/tagazon/src/api/objects/sellers/?id=${tag.seller}`,
                    type: "GET",
                    success: (response) => {
                        const { data } = response;
                        const seller = data[0];
                        $("#info-tag-seller").text(`Venduto da: ${seller.rag_soc}`);
                    }
                });
            }
        });

    }

    onUserLoad() {
        $("#add-to-cart").click(() => {
            const tagId = new URLSearchParams(document.location.search).get("tag_id");
            Application.cart.addItem(tagId);
        });
    }
}