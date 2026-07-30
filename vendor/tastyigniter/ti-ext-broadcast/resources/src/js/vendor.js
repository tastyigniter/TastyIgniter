import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo(app.broadcast.driver === 'reverb'
    ? {
        broadcaster: 'reverb',
        key: app.broadcast.reverbKey,
        wsHost: app.broadcast.reverbHost,
        wsPort: app.broadcast.reverbPort ?? 80,
        wssPort: app.broadcast.reverbPort ?? 443,
        forceTLS: app.broadcast.reverbForceTLS,
        enabledTransports: ['ws', 'wss'],
    }
    : {
        broadcaster: 'pusher',
        key: app.broadcast.pusherKey,
        cluster: app.broadcast.pusherCluster,
        authEndpoint: app.broadcast.pusherAuthUrl,
        forceTLS: app.broadcast.pusherEncrypted,
    }
);
