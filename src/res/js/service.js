self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    clients.openWindow("/?page=notifications");
});