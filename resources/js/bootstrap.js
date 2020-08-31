window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    window.toastr = require('toastr')
    require('bootstrap');
} catch (e) {}
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-bottom-right",
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadc  asting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
import firebase from 'firebase/app'
import 'firebase/auth'
import 'firebase/firestore'
import * as firebaseui from 'firebaseui'

const firebaseConfig = {
  apiKey: "AIzaSyBQAK_dBTbGOlC6piJD99IXlqJGWPeOmHk",
  authDomain: "ecommerce-ntk.firebaseapp.com",
  databaseURL: "https://ecommerce-ntk.firebaseio.com",
  projectId: "ecommerce-ntk",
  storageBucket: "ecommerce-ntk.appspot.com",
  messagingSenderId: "1021944174697",
  appId: "1:1021944174697:web:eb42d4779b9b18e105eaf8",
  measurementId: "G-8WZ2636QCR"
};
firebase.initializeApp(firebaseConfig);
window.firebase = firebase
window.auth = firebase.auth();
window.firebaseui = firebaseui;

// console.log('firebase file called')
// firebase.analytics();
