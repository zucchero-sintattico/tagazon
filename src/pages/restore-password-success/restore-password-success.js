class RestorePasswordSuccessPage extends Page {
    onPageLoad() {
        $("body > main > section > button").click(function() {
            window.location.href = "?page=login";
        });
    }
}