import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/store/auth";
import categoryRoutes from "@/routes/categoryRoutes";
import userRoutes from "@/routes/userRoutes";
import discountRoutes from "@/routes/discountRoutes";
import productRoutes from "@/routes/productRoutes";
import documentRoutes from "@/routes/documentRoutes";
import orderRoutes from "@/routes/orderRoutes";
import staffRoutes from "@/routes/staffRoutes";
import managerRoutes from "@/routes/managerRoutes";
import storeRoutes from "@/routes/storeRoutes";
import processRoutes from "@/routes/processRoutes";
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
                        title: "Trang chủ",
                        isAuth: true,
                    },
                    component: () => import("@/pages/Home.vue"),
                },
                ...userRoutes,
                ...categoryRoutes,
                ...discountRoutes,
                ...productRoutes,
                ...staffRoutes,
                ...managerRoutes,
                ...storeRoutes,
                ...processRoutes,
                //shop
                {
                    path: "shops",
                    name: "shop",
                    meta: {
                        title: "Quản lí sản phẩm trong cửa hàng",
                        isAuth: true,
                        requiredRole: ["ADMIN", "MANAGER", "STAFF"],
                    },
                    component: () => import("@/pages/Shop.vue"),
                },
                //change-password
                {
                    path: "change-password",
                    name: "change-password",
                    meta: {
                        title: "Đổi mật khẩu",
                        isAuth: true,
                    },
                    component: () => import("@/pages/ChangePassword.vue"),
                },
                //profile
                {
                    path: "profile",
                    name: "profile",
                    meta: {
                        title: "Thông tin cá nhân",
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
                        title: "Đăng nhập",
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
        window.location.replace("/admin/login");
        return;
    }

    if (to.meta?.requiredRole && !to.meta.requiredRole.includes(authStore.user.role)) {
        window.location.replace("/permission-denied");
        return;
    }

    next();
});

export default router;
