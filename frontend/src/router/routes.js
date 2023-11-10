import DashboardLayout from "@/components/Views/layouts/DashboardLayout";
import Login from "@/components/Views/auth/Login";

import homeRoute from './Home'

const baseRoutes = [
    {
        path: '/',
        component: DashboardLayout,
        redirect: '/home',
        meta: {requiresAuth: true}
    },
    {
        path: '/login',
        component: Login,
        name: 'login',
        meta: {title: 'Login'}
    },
];

const routes = baseRoutes.concat(
    homeRoute
);

export default routes;
