import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/store/auth";
import categoryRoutes from "@/routes/categoryRoutes";
import userRoutes from "@/routes/userRoutes";
import discountRoutes from "@/routes/discountRoutes";
import productRoutes from "@/routes/productRoutes";
import documentRoutes from "@/routes/documentRoutes";
import orderRoutes from "@/routes/orderRoutes";
const env = import.meta.env;

const router = createRouter({
    history: createWebHistory('/admin'),
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
                ...userRoutes,
                ...categoryRoutes,
                ...discountRoutes,
                ...productRoutes,
                //storage
                {
                    path: "storages",
                    name: "storage",
                    meta: {
                        title: "Storages management",
                        isAuth: true,
                        requiredRole: ["ADMIN", "MANAGER"],
                    },
                    component: () => import("@/pages/Storage.vue"),
                },
                //change-password
                {
                    path: "change-password",
                    name: "change-password",
                    meta: {
                        title: "Change password",
                        isAuth: true,
                    },
                    component: () => import("@/pages/ChangePassword.vue"),
                },
                //profile
                {
                    path: "profile",
                    name: "profile",
                    meta: {
                        title: "Profile",
                        isAuth: true,
                    },
                    component: () => import("@/pages/Profile.vue"),
                },
                ...documentRoutes,
                ...orderRoutes,
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
        {
            path: "/:catchAll(.*)",
            component: () => import("@/pages/Error404.vue")
        }
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

    if (to.meta?.requiredRole && !to.meta.requiredRole.includes(authStore.user.role)) {
        window.location.replace("/permission-denied");
        return;
    }

    next();
});

export default router;
