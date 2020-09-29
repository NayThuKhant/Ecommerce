import axios from 'axios'
import {app, router} from './app.js'

let user, order_ids, beforeGuard, afterGuard;

/**
 * Routes which need authentication
 */
let authentication = ['cart', 'orders', 'order.manage', 'addresses', 'MoreInfoView', 'add-address'];

/**
 * Define guarded (auth needed) route name here.
 */
let guarded = ['MoreInfoView',]

async function getCurrentUser() {
    try {
        let response = await axios.get('/user')
        user = response.data
    } catch (e) {
        toastr.error(e.message, "Error")
    }
}

async function fetchOrderIds() {
    try {
        let response = await axios.get('/api/order-ids')
        order_ids = response.data
    } catch (e) {
        toastr.error(e.message, "Error")
    }


}

async function defineRouteGuard() {
    if (!user) {
        await getCurrentUser()
    }
    if (user) {
        await fetchOrderIds()
    }



    beforeGuard = (to, from, next) => {
        //Vue Progress Bar on each route enter
        if (app) {
            app.$Progress.start()
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
         //  * User is authenticated but more info is not needed anymore.
         //  */
        else if (!user.more_info_needed && to.name === "MoreInfoView") {
            return next('/')
        }


        /**
         * Routes which need authentication
         */
        if (authentication.includes(to.name)) {
            if (user !== '') {
                next()
            } else {
                return next('login')
            }
        }


        /**
         * Orders Authorization
         */
        if (to.name == 'order.manage') {
            if (order_ids.includes(to.params.id)) {
                return next()
            } else {
                return next({name: 'notfound'})
            }
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
