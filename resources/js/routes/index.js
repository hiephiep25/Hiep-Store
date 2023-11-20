import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/store/auth";

const env = import.meta.env;

const router = createRouter({
    history: createWebHistory(),
    scrollBehavior: (to, from, savedPosition) => {
        if (to.hash) {
            return {
                el: to.hash,
                behavior: "smooth",
            };
        }
    },
    routes: [
        {
            path: "/",
            component: () => import("@/layout/Main.vue"),
            children: [
                {
                    path: "",
                    name: "home",
                    meta: {
                        title: "Home",
                        isAuth: true,
                    },
                    component: () => import("@/pages/Home.vue"),
                },
                {
                    path: "users",
                    name: "user.index",
                    meta: {
                        title: "User management",
                        isAuth: true,
                    },
                    component: () => import("@/pages/user/Index.vue"),
                },
                {
                    path: "users/create",
                    name: "user.create",
                    meta: {
                        title: "User management",
                        isAuth: true,
                    },
                    component: () => import("@/pages/user/Create.vue"),
                },
                {
                    path: "users/:id",
                    name: "user.edit",
                    meta: {
                        title: "User management",
                        isAuth: true,
                    },
                    component: () => import("@/pages/user/Edit.vue"),
                },
                {
                    path: "change-password",
                    name: "change-password",
                    meta: {
                        title: "Change password",
                        isAuth: true,
                    },
                    component: () => import("@/pages/ChangePassword.vue"),
                },
            ],
        },
        {
            path: "/",
            component: () => import("@/layout/Auth.vue"),
            children: [
                {
                    path: "login",
                    name: "login",
                    meta: {
                        title: "Login",
                        isAuth: false,
                    },
                    component: () => import("@/pages/Login.vue"),
                },
            ],
        },
    ],
});

router.beforeEach(async (to, from, next) => {
    document.title = to.meta?.title ?? env.VITE_APP_NAME;
    const authStore = useAuthStore();
    await authStore.verify();

    if (to.meta?.isAuth && !authStore.isAuth && to.name !== "login") {
        window.location.replace("/login");
        return;
    }

    next();
});

export default router;
