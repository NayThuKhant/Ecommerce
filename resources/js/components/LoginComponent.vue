<template>
    <div class="container mx-auto flex justify-center flex-col items-center" style="height: 400px">
        <div class="flex flex-col p-5 bg-gray-100 rounded-lg shadow">
            <a href="/login/github" class="flex items-center bg-gray-800 px-4 py-2 text-white text-sm rounded my-2"><i class="text-3xl mr-2 lab la-github"></i> sign in with github</a>
            <a href="/login/facebook" class="flex items-center bg-blue-500 px-4 py-2 text-white text-sm rounded my-2"><i class="text-3xl mr-2 lab la-facebook"></i> sign in with facebook</a>
            <a href="/login/google" class="flex items-center bg-red-400 px-4 py-2 text-white text-sm rounded my-2"><i class="text-3xl mr-2 lab la-google"></i> sign in with google</a>
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
