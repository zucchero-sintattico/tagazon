// Code here to be executed before all.

// if user is logged in, load main page
// PageManager.switchPage(Page.MAIN);
// else, load site home page
window.history.pushState(Page.HOME, null, window.location);
PageManager.switchPage(Page.HOME);

window.onpopstate = function(event) {
    PageManager.switchPage(new Page(event.state.name));
}
