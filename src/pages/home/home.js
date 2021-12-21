
$("#accedi").on("click", function(e) {
    e.preventDefault();
    window.history.pushState(Page.LOGIN, null, window.location);
    PageManager.switchPage(Page.LOGIN);
});