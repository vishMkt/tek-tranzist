<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
     <script type="module">


        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-app.js";
        import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-analytics.js";
        import { getMessaging, getToken ,onMessage } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-messaging.js";

       
        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const analytics = getAnalytics(app);

        // Initialize Firebase Cloud Messaging and get a reference to the service
        const messaging = getMessaging(app);

        console.log(messaging,app);

        const vapidKey = "BOvJa2CrLeIhwJLklHcp2YJtgZXMkC7pIqGv_mauMT2oiReSKubPzwlGgVXT8TkQSimGQXISEJGsS0gCJUq08uw"
         

        
        
        // var registration = navigator.serviceWorker.register('/public/js/core/firebase/firebase-messaging-sw.js', { type: 'module' });navigator.serviceWorker.register('/public/js/core/firebase/firebase-messaging-sw.js', { type: 'module' })
        // var registration;
        function service_worker(){
            if(true){
                navigator.serviceWorker.register('/firebase-messaging.js', { type: 'module' })
                .then(function(registration) {
                    // console.log('Service worker registration successful:', registration);
                    getToken(messaging,{ 
                        serviceWorkerRegistration: registration,
                        vapidKey: vapidKey
                    }).then((currentToken) => {
                        if (currentToken) {
                            // Send the token to your server and update the UI if necessary
                            // ...
                            console.log(currentToken);
                            // $.post("{{url('/store_fcm')}}",{
                            //     '_token':'{{csrf_token()}}',
                            //     'fcm_token':currentToken,
                            // }).then(function(resp){
                            //     console.log(resp);
                            // });

                        } else {
                            // Show permission request UI
                            console.log('No registration token available. Request permission to generate one.');
                            // ...
                        }
                    }).catch((err) => {
                        console.log('An error occurred while retrieving token. ', err);
                        // ...
                    });
                    // Call useServiceWorker() here using the registration object
                })
                .catch(function(error) {
                    console.error('Service worker registration failed:', error);
                });
            }
        }

        onMessage(messaging, (payload) => {
                console.log('Message received. ', payload);
                alert();
                const notificationTitle = payload.notification.title;
                const notificationOptions = {
                    body: payload.notification.body,
                    // icon: payload.notification.image,  // If you are sending an image
                };

                // Show a notification in the browser
                if (Notification.permission === 'granted') {
                    new Notification(notificationTitle, notificationOptions);
                }
        });
        
        Notification.requestPermission().then((permission) => {
            if (permission === 'granted') {
                console.log('Notification permission granted');
            } else {
                console.error('Notification permission not granted');
            }
        });
        
        service_worker();
        console.log(app, analytics, messaging)
    </script> 


</body>

</html>
