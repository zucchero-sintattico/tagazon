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

    const removeFromCartButton = document.createElement("button");
    removeFromCartButton.innerText = "-";
    removeFromCartButton.addEventListener("click", (e) => {
        e.stopPropagation();
        Application.cart.decreaseItemQuantity(item.tag.id);
    });

    const addToCartButton = document.createElement("button");
    addToCartButton.innerText = "+";
    addToCartButton.addEventListener("click", (e) => {
        e.stopPropagation();
        Application.cart.addItem(item.tag.id);
    });
    const h3 = document.createElement("h3");
    h3.innerText = `<${item.tag.name}>`;

    header.appendChild(removeFromCartButton);
    header.appendChild(addToCartButton);
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

export class CartPage extends NavbarPage {

    onCartChange() {
        super.onCartChange();

        $("#cart-items").empty();
        Application.cart.getItems().forEach(item => {
            $("#cart-items").append(createArticle(item));
        });

        if (Application.cart.getItems().length !== 0) {
            $("#cart-total").html(`(${Application.cart.getTotalPrice().toFixed(2)}€)`);
            $("#checkout").css("visibility", "visible");
            $("#empty-cart").hide(500);
        } else {
            $("#cart-total").html("");
            $("#checkout").css("visibility", "hidden");
            $("#empty-cart").show(500);
        }
    }

}