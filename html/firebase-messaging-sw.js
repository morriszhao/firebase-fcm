importScripts('https://www.gstatic.com/firebasejs/7.11.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.11.0/firebase-messaging.js');
var firebaseConfig = {
  apiKey: "",
  authDomain: "",
  databaseURL: "",
  projectId: "",
  storageBucket: "",
  messagingSenderId: "",
  appId: "",
  measurementId: ""
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

self.addEventListener('notificationclick', function(event) {
    let url = event.notification.tag;
    event.notification.close();
    event.waitUntil(
        clients.matchAll({type: 'window'}).then( windowClients => {
            for (var i = 0; i < windowClients.length; i++) {
                var client = windowClients[i];
                if (client.url === url && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});



messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received backgroundr message ', payload);
  const notificationTitle = payload.data.title;
  const notificationOptions = {
        body: payload.data.content,
        icon: payload.data.icon,
        tag:payload.data.tag,
        image: payload.data.image
  };


  console.log(self.registration)
  return self.registration.showNotification(notificationTitle,
    notificationOptions);
});
