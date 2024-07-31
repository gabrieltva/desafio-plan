import { createWebHistory, createRouter } from 'vue-router'

import Login from '@/pages/Login.vue'

const routes = [
  { 
    path: '/',
    name: 'login',
    component: Login
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('../pages/Register.vue')
  },
]

export const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})