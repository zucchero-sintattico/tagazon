$("input[type=radio]").on("change", function() {
    const val = $(this).val();
    $("section").fadeOut(500, function() {
        if (val === "cliente") {
            $("section").load("./pages/register/cliente.html");
        } else {
            $("section").load("./pages/register/venditore.html");
        }
        $("section").fadeIn(500);
    });
});