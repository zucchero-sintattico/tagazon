$(() => {

    UserManager.start(
        ifLogged = () => {
            NotificationsService.start();
        }
    );

    $.ajax({
        url: "api/objects/categories",
        type: "GET",
        success: loadCategory,
        error: (err) => { console.log(err); }
    });

    $.ajax({
        url: "api/objects/tags",
        type: "GET",
        success: loadTags,
        error: (err) => { console.log(err); }
    });

});

function loadCategory(data) {
    const categories = data["data"];

    categories.forEach(category => {
        $("#categories-list").append(`
            <li><button>${category["name"]}</button></li>
        `);
    });
}

function loadTags(data) {
    const tags = data["data"];

    console.log(tags);

    tags.forEach(tag => {
        $("#tags-list").append(`
            <article>
                <header>
                    <a href="#"><img src="res/img/icons/mail.webp" alt="info"></a>
                    <h3>${tag["name"]}</h3>
                </header>
                    <p>${encodeStr(tag["description"])}</p>
                <footer>
                    <p>${tag["price"]}€</p>
                </footer>
            </article>
        `);
    });
}

function encodeStr(str) {
    return str.replace(/[\u00A0-\u9999<>\&]/g, function(i) {
        return '&#' + i.charCodeAt(0) + ';';
    });
};
