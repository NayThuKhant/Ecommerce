import home from './views/home.vue'
import login from './views/auth/login.vue'
import category from './views/category.vue'
import product from "./views/product";
const Routes = [
    {
        path: '/',
        component: home
    },
    {
        path: '/login',
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
]
export default Routes;
