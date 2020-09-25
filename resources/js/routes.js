import home from './views/home.vue'
import login from './views/auth/login.vue'
import category from './views/category.vue'
import product from "./views/product";
import MoreInfoView from "./views/ProfileMgmt/MoreInfoView.vue";
import cart from "./views/cart"
import orders from "./views/orders";
import manage_order from "./views/manage_order";
import change_password from "./views/ProfileMgmt/change_password.vue";
import notfound from "./views/notfound";
import addresses from "./views/ProfileMgmt/addresses";
import edit_address from "./views/ProfileMgmt/edit_address";

const Routes = [
    {
        path: '/',
        name: 'home',
        component: home
    },
    {
        path: '/login',
        name: 'login',
        component: login
    },
    {
        path: '/categories/:slug',
        name: 'category',
        component: category
    },
    {
        path: '/products/:id',
        name: 'product.show',
        component: product
    },
    {
        path: '/finishing-up',
        name: 'MoreInfoView',
        component: MoreInfoView
    },
    {
        path: '/cart',
        name: 'cart',
        component: cart
    },
    {
        path : '/orders',
        name : 'orders',
        component: orders
    },
    {
        path : '/orders/:id/manage',
        name : 'order.manage',
        component: manage_order,
    },
    {
        path: '/change-password',
        name : 'change-password',
        component: change_password
    },
    {
        path : '/addresses',
        name : 'addresses',
        component : addresses
    },
    {
        path: '/addresses/:id/edit',
        name : 'edit.address',
        component : edit_address
    },
    {
        path: '*',
        name : 'notfound',
        component: notfound
    }

]
export default Routes
