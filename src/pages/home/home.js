import { Application } from "../../res/js/application.js";
import { NavbarPage } from "../navbar/navbar.js";

function createArticle(tag) {
    const article = document.createElement("article");
    article.ariaRoleDescription = "button"; /* for screen readers */

    /* event on click of all article */
    article.addEventListener(
        "click",
        () => {
            window.location.href = `./?page=info-tag&tag_id=${tag.id}`
        }
    );


    /* header */
    const header = document.createElement("header");
    const addToCartButton = document.createElement("button");
    addToCartButton.innerText = "+";
    addToCartButton.addEventListener("click", (e) => {
        e.stopPropagation();
        Application.cart.addItem(tag.id);
    });
    const h3 = document.createElement("h3");
    h3.innerText = `<${tag.name}>`;

    header.appendChild(addToCartButton);
    header.appendChild(h3);

    /* middle */
    const p = document.createElement("p");
    p.innerText = tag.description;

    /* footer */
    const footer = document.createElement("footer");
    const p_footer = document.createElement("p");

    p_footer.innerText = `${tag.price}€`;
    if (tag.sale_price !== null) {
        p_footer.innerHTML = `<del>${tag.price}€</del> ${tag.sale_price}€`;
    }

    footer.appendChild(p_footer);

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


/**
 * 
 * @param {string} object to get from server
 * @param {function} callback to execute on data["data"]
 */
function requestGet(request, callback) {
    $.ajax({
        url: request,
        type: "GET",
        success: (data) => callback(data.data),
        /* data: {code: Integer, message: String, data: Array} */
        error: (err) => { console.log(err); }
    });
}

/**
 * 
 */
function removeTags() {
    document.getElementById("tags-list").innerHTML = "";
}


/**
 * 
 * @param {Array} tags to load in the list of tags
 */
function loadTags(tags) {

    $("#tags-list").fadeOut(500, () => {
        removeTags();
        tags.forEach(tag => {
            $("#tags-list").append(createArticle(tag));
        });
        $("#tags-list").fadeIn(250);
    })

}

/**
 *  @param {Array} categories to load in the list
 */
function loadCategory(categories) {
    categories.forEach(category => {
        const li = document.createElement("li");
        const button = document.createElement("button");
        button.categoryId = category.id;
        button.innerText = category.name;
        button.addEventListener("click", handleChangeCategory);
        li.appendChild(button);
        $("#categories-list").append(li);
    });
}

/**
 * Event handler for categories buttons
 */
function handleChangeCategory() {
    if ($(this).hasClass("selected")) {
        $(this).removeClass("selected");
        $("#category-name").text("Tutte le categorie");
        requestGet("api/objects/tags", loadTags);
    } else {
        $("#categories-list > li > button").removeClass("selected");
        $(this).addClass("selected");
        $("#category-name").text($(this).text());
        requestGet(
            `/tagazon/src/api/objects/categories/tags/?category_id=${this.categoryId}`,
            (tags) => {
                return tags.length > 0 ? loadTags(tags) : requestGet("/api/objects/tags/", loadTags);
            },
        );
    }
}



export class HomePage extends NavbarPage {

    onUserLoad() {
        requestGet("/tagazon/src/api/objects/categories/", loadCategory);
        requestGet("/tagazon/src/api/objects/tags/", loadTags);
    }

}