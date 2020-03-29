$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    requestPermission();

    messaging.onTokenRefresh(() => {
        messaging.getToken().then((refreshedToken) => {
            console.log('Token refreshed.');
            sendTokenToServer(refreshedToken);
            getToken()
        }).catch((err) => {
            console.log('Unable to retrieve refreshed token.', err);
        });
    });

    messaging.onMessage((payload) => {
        console.log('Message received', payload);
        $('.notification-count').empty().html(payload.data['gcm.notification.badge']);
    });

    function requestPermission() {
        console.log('Requesting permission...');
        Notification.requestPermission().then((permission) => {
            if (permission == 'granted') {
                console.log('Notification permission granted.');
                getToken();
            }
            else {
                console.log('Unable to get permission to notify.');
            }
        });
    }

    function getToken() {
        messaging.getToken().then((currentToken) => {
            if (currentToken) {
                console.log(currentToken);
                $('#token').val(currentToken);
                sendTokenToServer(currentToken);
            }
            else {
                console.log('No Instance ID token available. Request permission to generate one.');
            }
        }).catch((err) => {
            console.log('An error occurred while retrieving token.', err);
        });
    }

    function sendTokenToServer(currentToken) {
        $.ajax({
            url: 'http://localhost/notification/token',
            method: 'POST',
            data: { token: currentToken },
            success: (result) => {
                console.log(result);
            },
            error: (result) => {
                console.log(result);
            }
        });
    }
});
