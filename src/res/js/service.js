// Notification click event listener
self.addEventListener('notificationclick', e => {
    // Close the notification popout
    e.notification.close();

});