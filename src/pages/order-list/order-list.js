import { Application } from '../../res/js/application.js';
import { NavbarPage } from '../navbar/navbar.js';

export class OrderListPage extends NavbarPage {

    createArticle(order) {

        const article = document.createElement("article");
        article.ariaRoleDescription = "button"; /* for screen readers */

        /* event on click of all article */
        article.addEventListener(
            "click",
            () => {
                window.location.href = `./?page=order-view&order_id=${order.getId()}`
            }
        );

        /* header */
        const header = document.createElement("header");

        const h3 = document.createElement("h3");
        h3.innerText = `Order number #${order.getId()}`;

        header.appendChild(h3);

        /* middle */
        const p = document.createElement("p");
        p.innerText = `Total: ${parseFloat(order.getAmount()).toFixed(2)}€`;

        /* footer */
        const footer = document.createElement("footer");
        const timestamp = document.createElement("p");

        timestamp.innerText = order.getTimestamp();

        footer.appendChild(timestamp);

        article.appendChild(header);
        article.appendChild(p);
        article.appendChild(footer);

        return article;

        return `
            <article>
                <h3>Order number #${order.id}</h3>
                <p>Total: ${parseFloat(order.amount).toFixed(2)}€</p><p>${order.timestamp}</p>
            </article>
        `;
    }

    onOrdersReady() {
        super.onUserLoad();

        Application.orders.forEach((order) => {
            const article = this.createArticle(order);
            $("#orders").prepend(article);
        });

        if (Application.orders.length !== 0) {
            $("#empty-orders").hide(500);
        } else {
            $("#empty-orders").show(500);
        }
    }
}