$(() => {

    $("section").load("./pages/register/cliente.html");
    $("section").fadeIn(500);

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

    $("form").submit(function(e) {
        e.preventDefault();
        let type = $("input[type=radio]").val();
        if (type == "cliente") {
            UserManager.registerBuyer(
                $("#email").val(),
                $("#password").val(),
                $("#nome").val(),
                $("#cognome").val(),
            );
        } else {
            UserManager.registerSeller(
                $("#email").val(),
                $("#password").val(),
                $("#rag_soc").val(),
                $("#piva").val(),
            );
        }

    });
});