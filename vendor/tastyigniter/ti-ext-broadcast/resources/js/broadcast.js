+function ($) {
    "use strict"

    window.Broadcast = {
        event: undefined,

        init: function () {
            if (window.Echo === undefined) {
                console.error('Broadcast.Echo is undefined, configure the broadcast settings from the admin panel.');
                return;
            }

            if (!app.broadcast.pusherUserChannel)
                return;

            $('[data-control="notification-list"]').on('click', '[data-bs-toggle="dropdown"]', function () {
                Broadcast.checkNotificationPermission()
            });

            Broadcast.user().notification(Broadcast.pushNotification)
        },

        channel: function (name) {
            return window.Echo.channel(name)
        },

        user: function () {
            return window.Echo.private(app.broadcast.pusherUserChannel)
        },

        pushNotification: function (notification) {
            // Let's check if the browser supports notifications
            if (!('Notification' in window)) {
                console.error('This browser does not support notifications.');
                return;
            }

            // Let's check whether notification permissions have already been granted
            if (Notification.permission === 'granted') {
                Broadcast.createNotification(notification)
            } else if (Notification.permission !== 'denied') {
                Notification.requestPermission().then(permission => {
                    if (permission === 'granted') {
                        Broadcast.createNotification(notification)
                    }
                });
            }
        },

        checkNotificationPermission: function () {
            if (!('Notification' in window)) {
                console.error('This browser does not support notifications.');
                return;
            }

            Notification.requestPermission()
                .then(Broadcast.permissionGranted)
                .catch(Broadcast.permissionDenied);
        },

        permissionGranted: function (permission) {
        },

        permissionDenied: function (error) {
        },

        createNotification: function (notification) {
            const notificationObject = new Notification(notification.title, {
                body: notification.message,
            });

            notificationObject.onclick = function (event) {
                event.preventDefault(); // prevent the browser from focusing the Notification's tab
                window.focus();
                window.location = notification.url
            }
        }
    }

    $(document).ready(function () {
        Broadcast.init();
    });
}(jQuery);
