import { createRouter, createWebHistory } from "vue-router";
import AppLayout from '../components/AppLayout.vue';
import Dashboard from '../views/Dashboard.vue';
import Products from '../views/products/Products.vue';
import Users from '../views/Users/Users.vue';
import Customers from '../views/Customers/Customers.vue';
import Invoices from '../views/invoices/Invoices.vue';
import InvoiceView from '../views/invoices/InvoiceView.vue'
import Login from '../views/Login.vue';
import RequestPasswordReset from '../views/RequestPasswordReset.vue';
import ResetPassword from '../views/ResetPassword.vue';
import NotFound from '../views/NotFound.vue'
import store from "../store";

const routes = [

    {
        path: '/app',
        name: 'app',
        component: AppLayout,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: 'dashboard',
                name: 'app.dashboard',
                component: Dashboard
            },
            {
                path: 'products',
                name: 'app.products',
                component: Products
            },

            {
                path: 'users',
                name: 'app.users',
                component: Users
            },
            {
                path: 'customers',
                name: 'app.customers',
                component: Customers
            },
            {
                path: 'invoices',
                name: 'app.invoices',
                component: Invoices
            },
            {
                path: 'invoice/:id',
                name: 'app.invoices.view',
                component: InvoiceView
            },
        ]
    }
    ,
    {
        path: '/login',
        name: 'login',
        meta: {
            guest: true,
        },
        component: Login
    },
    {
        path: '/request-password',
        name: 'requestPassword',
        meta: {
            guest: true,
        },
        component: RequestPasswordReset
    },
    {
        path: '/reset-password/:token',
        name: 'resetPassword',
        meta: {
            guest: true,
        },
        component: ResetPassword
    },
    {
        path: '/:pathMatch(.*)',
        name: 'notfound',
        component: NotFound
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: 'login' })
    } else if (to.meta.guest && store.state.user.token) {
        next({ name: 'app.dashboard' })
    } else {
        next()
    }
})

export default router;