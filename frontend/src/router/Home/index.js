import DashboardLayout from "@/components/Views/layouts/DashboardLayout";
import HelloWorld from "@/components/HelloWorld";

export default [
    {
        path: '/',
        component: DashboardLayout,
        redirect: '/',
        children: [
            {
                path: 'home',
                name: 'HelloWorld',
                component: HelloWorld,
                meta: {title: 'My Plan List', requiresAuth: true}
            }
        ]
    }
];
