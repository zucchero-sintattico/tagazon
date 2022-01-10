import { Application } from "../../res/js/application.js";
import { NavbarPage } from "../navbar/navbar.js";

function createArticle(item) {
    const article = document.createElement("article");
    article.ariaRoleDescription = "button"; /* for screen readers */

    /* event on click of all article */
    article.addEventListener(
        "click",
        () => {
            window.location.href = `./?page=info-tag&tag_id=${item.tag.id}`
        }
    );


    /* header */
    const header = document.createElement("header");

    const h3 = document.createElement("h3");
    h3.innerText = `<${item.tag.name}>`;

    header.appendChild(h3);

    /* middle */
    const p = document.createElement("p");
    p.innerText = item.tag.description;

    /* footer */
    const footer = document.createElement("footer");
    const price = document.createElement("p");
    const quantity = document.createElement("p");

    price.innerText = `${item.tag.getPrice()}€`;
    if (item.tag.isInSale()) {
        price.innerHTML = `<del>${item.tag.getPriceWithoutSale()}€</del> ${item.tag.getPrice()}€`;
    }
    quantity.innerText = `Quantity: ${item.getQuantity()}`;

    footer.appendChild(price);
    footer.appendChild(quantity);

    /* 
        <article>
            <header>
                <button>+</button>
                <h3>Name</h3>
            </header>
            <p>Description</p>
            <footer>
                <p>Price</p>
            </footer>
        </article>
    */

    article.appendChild(header);
    article.appendChild(p);
    article.appendChild(footer);

    return article;
}

export class OrderViewPage extends NavbarPage {

    onOrdersReady() {

        const orderId = new URLSearchParams(document.location.search).get("order_id");
        $("h1").text(`Order: #${orderId}`);
        $("#order-items").empty();
        const order = Application.orders.find(order => order.getId() == orderId);
        order.items.forEach(item => {
            $("#order-items").append(createArticle(item));
        });

    }

}