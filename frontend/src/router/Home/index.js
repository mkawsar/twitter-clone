import DashboardLayout from "@/components/Views/layouts/DashboardLayout";
import Home from "@/components/Home";

export default [
    {
        path: '/',
        component: DashboardLayout,
        redirect: '/',
        children: [
            {
                path: 'home',
                name: 'Home',
                component: Home,
                meta: {title: 'Home', requiresAuth: true}
            }
        ]
    }
];
