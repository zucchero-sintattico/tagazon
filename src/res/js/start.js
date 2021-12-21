/**
 * Start the session with the server.
 * Include this file in the base html file in order to be sure that the session is started.
 */
$(() => {
    $.ajax({
        url: 'http://localhost/tagazon/src/api/api.php',
        method: 'GET',
        success: (data) => {
            if (data["code"] == 200) {
                console.log("Session started successfully");
            }
        },
        error: (data) => {
            console.log("Error starting session : " + data);
        }
    });
});