import { createRouter, createWebHistory } from 'vue-router'

import authService from '@/services/auth.service'
import MainLayout from '@/layouts/MainLayout.vue'


/*
|--------------------------------------------------------------------------
| Views
|--------------------------------------------------------------------------
*/

import LoginView from '@/views/auth/LoginView.vue'
import DashboardView from '@/views/dashboard/DashboardView.vue'
import DirectoryView from '@/views/directory/DirectoryView.vue'
import StreetsView from '@/views/streets/StreetsView.vue'
import ResidentsView from '@/views/residents/ResidentsView.vue'
import UsersView from '@/views/users/UsersView.vue'
import AuditView from '@/views/audit/AuditView.vue'
import ActiveUsersView from '@/views/active-users/ActiveUsersView.vue'
import RolesView from '@/views/roles/RolesView.vue'



/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
*/
const routes = [

  
/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

    {
        path: '/login',

        name: 'login',

        component: LoginView,

        meta: {

            requiresGuest: true
        }
    },

    /*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
    {
    path: '',

    component: MainLayout,

    meta: {

        requiresAuth: true
    },

    children: [

        {
            path: 'dashboard',

            name: 'dashboard',

            component: DashboardView
        },

        

        /*
|--------------------------------------------------------------------------
| Streets
|--------------------------------------------------------------------------
*/

        {
    path: '/streets',

    name: 'streets',

    component: StreetsView,

    meta: {
        requiresAuth: true
    }
},


/*
|--------------------------------------------------------------------------
| Residents
|--------------------------------------------------------------------------
*/

{
    path: '/residents',

    name: 'residents',

    component: ResidentsView,

    meta: {
        requiresAuth: true
    }
},


   /*
|--------------------------------------------------------------------------
| Directory
|--------------------------------------------------------------------------
*/

{
    path: '/directory',

    name: 'directory',

    component: DirectoryView,

    meta: {

        requiresAuth: true
    }
},



        /*
|--------------------------------------------------------------------------
| Users
|--------------------------------------------------------------------------
*/
      /*  {
    path: 'users',

    name: 'users',

    component: UsersView
},*/

{
    path: '/users',

    name: 'users',

    component: UsersView,

    meta: {
        requiresAuth: true
    }
},


/*
|--------------------------------------------------------------------------
| Audit
|--------------------------------------------------------------------------
*/

{
    path: '/audit',

    name: 'audit',

    component: AuditView,

    meta: {

        requiresAuth: true,

        allowedRoles: [1, 2]
    }
},

/*
|--------------------------------------------------------------------------
| Configurations-Users
|--------------------------------------------------------------------------
*/


{
    path: 'roles',

    name: 'roles-config',

    component: RolesView,

    meta: {

        requiresAuth: true,

        allowedRoles: [1]
    }
},


/*
|--------------------------------------------------------------------------
| Active-Users
|--------------------------------------------------------------------------
*/

{
    path: '/active-users',

    name: 'active-users',

    component: ActiveUsersView,

    meta: {
        requiresAuth: true
    }
},


    ]
},

    /*
|--------------------------------------------------------------------------
| Default redirect
|--------------------------------------------------------------------------
*/
    {
        path: '/',

        redirect: '/dashboard'
    },

    /*
|--------------------------------------------------------------------------
| 404 fallback
|--------------------------------------------------------------------------
*/
    {
        path: '/:pathMatch(.*)*',

        redirect: '/dashboard'
    }
]

/*
|--------------------------------------------------------------------------
| Router
|--------------------------------------------------------------------------
*/
const router = createRouter({

    history: createWebHistory(),

    routes
})

/*
|--------------------------------------------------------------------------
| Router Guard
|--------------------------------------------------------------------------
*/
router.beforeEach((to, from, next) => {

    const isAuthenticated = authService.isAuthenticated()

    /*
|--------------------------------------------------------------------------
| Protected routes
|--------------------------------------------------------------------------
*/
    if (

        to.meta.requiresAuth &&
        !isAuthenticated

    ) {

        return next('/login')
    }

    /*
|--------------------------------------------------------------------------
| Guest Only
|--------------------------------------------------------------------------
*/
    if (

        to.meta.requiresGuest &&
        isAuthenticated

    ) {

        return next('/dashboard')
    }


    /*
|--------------------------------------------------------------------------
| Role Guard
|--------------------------------------------------------------------------
*/

    if (to.meta.allowedRoles) {

        const user = authService.getUser()

        if (

            !user ||

            !to.meta.allowedRoles.includes(
    Number(user.Role_id)
)
        ) {

            return next('/dashboard')
        }
    }



    next()
})

export default router