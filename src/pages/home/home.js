$("#accedi").on("click", function(e) {
    e.preventDefault();
    $("body").fadeOut(500, function() {
        PageManager.switchPage(Page.LOGIN, () => $("body").fadeIn(500));
    });
});