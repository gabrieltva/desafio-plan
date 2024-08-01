import { createWebHistory, createRouter } from 'vue-router'

import Login from '@/pages/Login.vue'
import authGuard from '@/middlewares/authGuard'
import authCheck from '@/middlewares/authCheck'

const routes = [
  { 
    path: '/',
    name: 'login',
    component: Login,
    meta: { checkAuth: true },
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('../pages/Register.vue'),
    meta: { checkAuth: true },
  },
  {
    path: '/admin/dashboard',
    name: 'adminDashboard',
    component: () => import('../pages/admin/Dashboard.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/admin/students',
    name: 'adminStudentsList',
    component: () => import('../pages/admin/students/List.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/admin/courses',
    name: 'adminCoursesList',
    component: () => import('../pages/admin/courses/List.vue'),
    meta: { requiresAuth: true },
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    authGuard(to, from, next);
  }
  else if (to.matched.some(record => record.meta.checkAuth)) {
    authCheck(to, from, next);
  } else {
    next();
  }
});

export default router;
