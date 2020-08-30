window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

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
    apiKey: "AIzaSyCVSJ6kY3zDYJqr9U-l4LvJWI1t9iH1waA",
    authDomain: "ecommerce-eb28f.firebaseapp.com",
    databaseURL: "https://ecommerce-eb28f.firebaseio.com",
    projectId: "ecommerce-eb28f",
    storageBucket: "ecommerce-eb28f.appspot.com",
    messagingSenderId: "1001703752196",
    appId: "1:1001703752196:web:2f0983b00f622f0c70eb51"
};
firebase.initializeApp(firebaseConfig);
window.firebase = firebase
window.auth = firebase.auth();
window.firebaseui = firebaseui;

// console.log('firebase file called')
// firebase.analytics();
