<template>
    <div id="firebase-auth-container"></div>
</template>

<script>
export default {
    name: "LoginComponent",
    data() {
        return {

        }
    },
    mounted() {
        $(document).ready(() => {
            this.startSigninUi();
        })
    },
    methods: {
        startSigninUi() {
            let ui = new firebaseui.auth.AuthUI(auth);
            let signinConfig = {
                callbacks: {
                    signInSuccessWithAuthResult: (authResult, redirectUrl) => {
                        authResult.user.getIdToken()
                        .then((idToken) => {
                            console.log(idToken)
                            axios.post('/login-firebase', {
                                idToken
                            })
                            .then((response) => {
                                window.location.replace('/')
                            })
                            .catch((e) => {
                                console.log(e)
                            })
                        })
                        return false
                    }
                },
                credentialHelper: firebaseui.auth.CredentialHelper.NONE,
                signInSuccessUrl: '/',
                signInOptions: [
                    firebase.auth.EmailAuthProvider.PROVIDER_ID,
                    firebase.auth.GoogleAuthProvider.PROVIDER_ID,
                    {
                        provider: firebase.auth.PhoneAuthProvider.PROVIDER_ID,
                        recaptchaParameters: {
                            type: 'image', // 'audio'
                            size: 'invisible', // 'invisible' or 'compact'
                            badge: 'bottomRight' //' bottomright' or 'inline' applies to invisible.
                        },
                        defaultCountry: 'MM',
                        defaultNationalNumber: '9251234456',
                    }
                ]
            }
            ui.start("#firebase-auth-container", signinConfig)
        }
    }
}
</script>

<style scoped>

</style>
