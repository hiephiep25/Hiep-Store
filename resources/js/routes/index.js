import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/store/auth';

const env = import.meta.env;

const router = createRouter({
  history: createWebHistory(),
  scrollBehavior: (to, from, savedPosition) => {
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'smooth',
      }
    }
  },
  routes: [
    {
      path: '/',
      component: () => import('@/layout/Main.vue'),
      children: [
        {
          path: '',
          name: 'home',
          meta: {
            title: "Home",
            isAuth: true,
          },
          component: () => import('@/pages/Home.vue'),
        },
      ],
    },
    {
      path: '/',
      component: () => import('@/layout/Auth.vue'),
      children: [
        {
          path: 'login',
          name: 'login',
          meta: {
            title: "Login",
            isAuth: false,
          },
          component: () => import('@/pages/Login.vue'),
        },
      ],
    },
  ],
});


router.beforeEach(async (to, from, next) => {
  document.title = to.meta?.title ?? env.VITE_APP_NAME;
  const authStore = useAuthStore();
  await authStore.verify();

  if (to.meta?.isAuth && !authStore.isAuth && to.name !== 'login') {
    window.location.replace('/login')
    return;
  }

  next()
});


export default router;
