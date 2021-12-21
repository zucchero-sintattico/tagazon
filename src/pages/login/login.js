$("html").fadeIn();
$("#registrati").on("click", function(e) {
    e.preventDefault();
    window.history.pushState(Page.REGISTER, null, window.location);
    PageManager.switchPage(Page.REGISTER);
});