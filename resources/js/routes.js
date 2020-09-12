import home from './views/home.vue'
import login from './views/auth/login.vue'
import category from './views/category.vue'
import product from "./views/product";
import MoreInfoView from "./views/ProfileMgmt/MoreInfoView.vue";
import cart from "./views/cart"
import orders from "./views/orders";
import change_password from "./views/ProfileMgmt/change_password.vue";

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
    }
]
export default Routes
