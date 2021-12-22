$(document).ready(function() {
    //Hide error message
    $("body > main > section > footer > p").hide();
    
    //Control submit button
    $("input[type='submit']").click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "/tagazon/src/api/users/reset-password/",
            type: "POST",
            data: {
                email:$("email").val()
            },
            success: function(data){
                //TODO: Switch to success-email.html
                window.location.href = "?page=restore-password-success";
                console.log(data);
            },
            error: function(data){
                showErrorMessage("Errore! L'email inserita non è valida");
            }
        })
    });
});

//Used to show an default error message whit text
function showErrorMessage(errorMessage) {
    $("body > main > section > footer > p").html(errorMessage);
    $("body > main > section > footer > p").fadeIn(500);
    $("body > main > section > form > fieldset > input[type='email']").addClass("error");
}