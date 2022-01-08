import { Application } from '../../res/js/application.js';
import { NavbarPage } from '../navbar/navbar.js';

export class OrderListPage extends NavbarPage {

    createArticle(order) {
        return `
            <article>
                <h3>Order number #${order.id}</h3>
                <p>Total: ${parseFloat(order.amount).toFixed(2)}€</p><p>${order.timestamp}</p>
            </article>
        `;
    }

    onOrdersReady() {
        super.onUserLoad();

        console.log(Application.orders);
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