// import router functions
import { createRouter, createWebHistory } from 'vue-router'


import login from '@/pages/login.vue'
import app from '@/pages/app.vue'
import {useAuthStore} from '@/stores/authuser'

import users from '@/pages/users.vue'
import usersIndex from '@/pages/users/index.vue'
import usersShow from '@/pages/users/show.vue'
import projet from '@/pages/projet.vue'
import audit from '@/pages/audit.vue'



// setup routes

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/login',
            name: 'login',
            component: login,
        },
        {
            path: '/',
            name: 'projet',
            component: app,
            children: [
                {
                    path: '/',
                    name: 'dash',
                    component: projet,
                },
                {
                    path: 'audit/:id',
                    name: 'audit',
                    component: audit,
                },
                {
                    path: '/users',
                    name: 'users',
                    component: users,
                    children: [
                        {
                            path: '',
                            name: 'usersIndex',
                            component: usersIndex,

                        },
                        {
                            path: ':id',
                            name: 'usersShow',
                            component: usersShow,

                        },
                    ],
                    meta : {
                        roles : ["Admin"]
                    }
                },
            ]
        },

    ]
})

router.beforeEach((to, from, next) => {
    if(to.query.s){
        const userStore = useAuthStore()

        localStorage.setItem('token',to.query.s)
        userStore.setRole(to.query.role);
        window.location.replace('/')


    }
    if (to.name !== 'login' && localStorage.getItem('token') == null) next({ name: 'login' })
    else if (to.name == 'login' && localStorage.getItem('token') != null) next({ name: 'projet' })
    else next()
})
router.beforeEach((to, from, next) => {
    const userStore = useAuthStore()

    const userRole = userStore.data.role;
    const requiredRoles = to.meta.roles || [] 
  
    if (requiredRoles.length > 0 && !requiredRoles.includes(userRole)) {
      next('/403') 
    } else {
      next() 
    }
  })
export default router
