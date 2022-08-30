importScripts("https://www.gstatic.com/firebasejs/7.16.1/firebase-app.js");
importScripts(
    "https://www.gstatic.com/firebasejs/7.16.1/firebase-messaging.js",
);
// For an optimal experience using Cloud Messaging, also add the Firebase SDK for Analytics.
importScripts(
    "https://www.gstatic.com/firebasejs/7.16.1/firebase-analytics.js",
);

// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
firebase.initializeApp({
    messagingSenderId: "788937427635",
    apiKey: "AIzaSyCkInVj4z7SCEzXBhukYD4TdcMKpC8sDJg",
    projectId: "autoswift-v5",
    appId: "1:788937427635:web:5da96bd05c18eb7c3e7ec6",
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
   
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    // Customize notification here
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/logo_auto.png",
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});