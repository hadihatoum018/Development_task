export const routes = [
    {
        path: '/',
        component: ()=>import('./components/Auth/Auth'),
        redirect: '/login',
        children:[
            {
                path: '/login',
                name:'Login',
                meta:{
                    title: 'Login | VueDashboard'
                },
                component:()=>import('./components/Auth/Login')
            },
            {
                path: '/register',
                name:'register',
                meta:{
                    title: 'Register | VueDashboard'
                },
                component:()=>import('./components/Auth/Register')
            },
        ]
    },
    {
        path: '/',
        redirect: '/login',
        component:()=>import('./components/Layout/Layout'),
        children: [
            {
                path: '/dashboard',
                name: 'dashboard',
                meta: {
                    title: 'My Dashboard | Vue Dashboard'
                },
                component:()=>import('./components/Dashboard/Dashboard'),
            },
            {
                path: '/project',
                name: 'project',
                meta: {
                    title: 'Project | Vue Dashboard'
                },
                component:()=>import('./components/Project/Project'),
            },
            {
                path: '/logout',
                name: 'logout',
                meta: {
                    title: 'Logout | Vue Dashboard'
                },
                component:()=>import('./components/Logout'),
            },

        ]
    },
    {
        path:'*',
        component: () => import('./components/Errors/NotFound')
    }
];
