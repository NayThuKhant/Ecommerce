import axios from 'axios'
import { app, router } from './app.js'

let user, beforeGuard, afterGuard;

/**
 * Define guarded (auth needed) route name here.
 */
let guarded = ['MoreInfoView']

async function getCurrentUser() {
    try {
        let response = await axios.get('/api/user')
        user = response.data
    }
    catch (e) {
        toastr.error(e.message, "Error")
    }
}

async function defineRouteGuard() {
    if (!user) {
        await getCurrentUser()
    }
    beforeGuard = (to, from, next) => {
        //Vue Progress Bar on each route enter
        if (app) {
            app.$Progress.start()
        }
        /**
         * If user is not authenticated and intended link is guarded
         * redirect back to home
        **/
        if (user === "" && guarded.includes(to.name)) {
            return next("/")
        }
        /**
         * User is authenticated but more info is needed
         */
        if (user !== "" && user.more_info_needed) {
            if (to.name === "MoreInfoView") {
                return next()
            }
            return next({name: "MoreInfoView"})
        }
        /**
         * User is authenticated but more info is not needed anymore.
         */
        else if (!user.more_info_needed && to.name === "MoreInfoView") {
            return next('/')
        }
        return next()
    }
    afterGuard = (to, from) => {
        if (app) {
            app.$Progress.finish()
        }
    }
    router.beforeEach(beforeGuard)
    router.afterEach(afterGuard)
}

export default defineRouteGuard
