$("#registrati").on("click", function(e) {
    e.preventDefault();
    $("body").fadeOut(500, function() {
        PageManager.switchPage(Page.REGISTER, () => $("body").fadeIn(500));
    });
});