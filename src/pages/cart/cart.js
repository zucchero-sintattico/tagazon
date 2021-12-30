Application.whenUserReady(() => {

    Application.onCartChange(() => {

        if (Application.cart.getTotalQuantity() > 0) {
            $("#cart-counter").text(Application.cart.getTotalQuantity());
            $("#cart-counter").fadeIn(500);
        } else {
            $("#cart-counter").hide();
        }

        $("#cart-items").html("");
        Application.cart.getItems().forEach(item => {
            $("#cart-items").append(createArticle(item));
        });

    })

    Application.onNotificationChange(() => {
        let unseen = Application.notifications.filter(notification => !notification.getSeen()).length;
        if (unseen > 0) {
            $("#notification-counter").text(unseen);
            $("#notification-counter").fadeIn(500);
        } else {
            $("#notification-counter").hide();
        }
    });

    // give id of navbar like pages!!!
    const page = new URLSearchParams(document.location.search).get("page");
    $(`#${page}`).addClass("active-page");
});

function createArticle(item) {
    const article = document.createElement("article");
    article.ariaRoleDescription = "button"; /* for screen readers */

    /* event on click of all article */
    article.addEventListener(
        "click",
        () => window.location.href = `./?page=info_tag&tag_id=${tag["id"]}`
    );


    /* header */
    const header = document.createElement("header");

    let removeFromCartButton = document.createElement("button");
    removeFromCartButton.innerText = "-";
    removeFromCartButton.addEventListener("click", (e) => {
        e.stopPropagation();
        Application.cart.decreaseItemQuantity(item["tag"]["id"]);
    });

    let addToCartButton = document.createElement("button");
    addToCartButton.innerText = "+";
    addToCartButton.addEventListener("click", (e) => {
        e.stopPropagation();
        addToCart(item["tag"]["id"])
    });
    const h3 = document.createElement("h3");
    h3.innerText = `<${item["tag"]["name"]}>`;

    header.appendChild(removeFromCartButton);
    header.appendChild(addToCartButton);
    header.appendChild(h3);

    /* middle */
    const p = document.createElement("p");
    p.innerText = item["tag"]["description"];

    /* footer */
    const footer = document.createElement("footer");
    const price = document.createElement("p");
    const quantity = document.createElement("p");
    price.innerText = `${item["tag"].getPrice()}€`;
    quantity.innerText = `${item.getQuantity()}`;

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

function decreaseFromCart(tag_id) {
    Application.cart.decreaseItemQuantity(tag_id);
}

function addToCart(tag_id) {
    Application.cart.addItem(tag_id);
}