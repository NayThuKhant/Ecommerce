<template>
    <div class="container mx-auto">
        <div class="w-full max-w-lg mt-6 mx-auto rounded-lg border border-gray-400 px-4 py-4">
            <h5 class="uppercase tracking-wide text-gray-800 text-base font-bold mb-5 ">
                Sign in / Register
            </h5>
            <div id="firebase-auth-container"></div>
            <spinner-component/>
        </div>
    </div>
</template>

<script>

let ui = new firebaseui.auth.AuthUI(auth);
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
    beforeDestroy() {
        ui.reset()
    },
    methods: {
        startSigninUi() {
            let signinConfig = {
                callbacks: {
                    signInSuccessWithAuthResult: (authResult, redirectUrl) => {
                        authResult.user.getIdToken()
                        .then((idToken) => {
                            document.querySelector('#component-spinner').style.display = 'flex'
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
                    },
                    uiShown() {
                        document.querySelector('#component-spinner').style.display = 'none'
                    }
                },
                credentialHelper: firebaseui.auth.CredentialHelper.NONE,
                signInSuccessUrl: '/',
                signInOptions: [
                    firebase.auth.GoogleAuthProvider.PROVIDER_ID,
                    firebase.auth.FacebookAuthProvider.PROVIDER_ID,
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
