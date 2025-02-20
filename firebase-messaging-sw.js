importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-auth.js');

firebase.initializeApp({
    apiKey: "AIzaSyC3x_YiaCCHsvnkLUfWRilmBG-SErQfFtg",
    authDomain: "abkrino-ba227.firebaseapp.com",
    projectId: "abkrino-ba227",
    storageBucket: "abkrino-ba227.appspot.com",
    messagingSenderId: "830039760364",
    appId: "1:830039760364:android:6c128d8e695a86258bf4c9",
    measurementId: ""
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    return self.registration.showNotification(payload.data.title, {
        body: payload.data.body || '',
        icon: payload.data.icon || ''
    });
});