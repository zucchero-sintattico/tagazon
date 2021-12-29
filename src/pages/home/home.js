$(() => {

    UserManager.start(
        ifLogged = () => {
            NotificationsService.start();
        }
    );

    request("/tagazon/src/api/objects/categories/", loadCategory);
    request("/tagazon/src/api/objects/tags/", loadTags);

});

/**
 * 
 * @param {string} object to get from server
 * @param {function} callback to execute on data["data"]
 */
function request(request, callback) {
    $.ajax({
        url: request,
        type: "GET",
        success: (data) => callback(data["data"]),
        /* data: {code: Integer, message: String, data: Array} */
        error: (err) => { console.log(err); }
    });
}

/**
 *  @param {Array} categories to load in the list
 */
function loadCategory(categories) {
    categories.forEach(category => {
        const li = document.createElement("li");
        const button = document.createElement("button");
        button.categoryId = category["id"];
        button.innerText = category["name"];
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
        request("api/objects/tags", loadTags);
    } else {
        $("#categories-list > li > button").removeClass("selected");
        $(this).addClass("selected");
        $("#category-name").text($(this).text());
        request(
            `/tagazon/src/api/objects/categories/tags/?category_id=${this.categoryId}`,
            (tags) => tags.length > 0 ? loadTags(tags) : request("/api/objects/tags/", loadTags),
        );
    }
}

/**
 * 
 * @param {Array} tags to load in the list of tags
 */
function loadTags(tags) {

    $("#tags-list").fadeOut(500, () => {
        removeTags();
        tags.forEach(tag => {
            const article = document.createElement("article");
            article.ariaRoleDescription = "button"; /* for screen readers */
            article.addEventListener(
                "click", 
                () => window.location.href = `./?page=info_tag&tag_id=${tag["id"]}`
            );
            article.innerHTML = `
                    <header>
                        <a href="#"><img src="res/img/icons/mail.webp" alt="info"></a>
                        <h3>&lt;${tag["name"]}&gt;</h3>
                    </header>
                        <p>${encodeStr(tag["description"])}</p>
                    <footer>
                        <p>${tag["price"]}€</p>
                    </footer>
            `;
            $("#tags-list").append(article);
        });
        $("#tags-list").fadeIn(250);
    })

}

/**
 * 
 */
function removeTags() {
    document.getElementById("tags-list").innerHTML = "";
}

function encodeStr(str) {
    return str.replace(/[\u00A0-\u9999<>\&]/g, function(i) {
        return '&#' + i.charCodeAt(0) + ';';
    });
};