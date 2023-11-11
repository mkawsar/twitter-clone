import DashboardLayout from "@/components/Views/layouts/DashboardLayout";
import Home from "@/components/Home";
import Search from "@/components/Search";
import ProfileIndex from "@/components/Profile/Index";

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
            },
            {
                path: 'search',
                name: 'Search',
                component: Search,
                meta: {title: 'Search', requiresAuth: true}
            },
            {
                path: 'profile/view',
                name: 'ProfileIndex',
                component: ProfileIndex,
                meta: {title: 'My Profile', requiresAuth: true}
            }
        ]
    }
];
