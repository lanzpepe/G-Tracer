$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    var base = window.location.origin;

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
        $('.notification-count').empty().html(payload.data['gcm.notification.badge']);
        $('body').toast({
            class: 'info',
            showIcon: 'bell',
            title: payload.notification['title'],
            message: payload.notification['body'],
            transition: {
                showMethod: 'fade left',
                hideMethod: 'fade left'
            }
        });
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
            url: `${base}/notifications/token`,
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
