class Application {

    static user = null;
    static authManager = new AuthManager();
    static notificationsService = new NotificationsService();

    static start(onReady = () => {}) {
        this.authManager.start(
            (user) => {

                Application.user = new User(user["id"], user["email"], user["type"], () => {
                    console.log("User loaded");
                    Application.notificationsService.start();
                    onReady();
                });


            }
        );
    }

}