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
                //user
                {
                    path: "users",
                    name: "user.index",
                    meta: {
                        title: "User management",
                        isAuth: true,
                        requiredRole: "ADMIN",
                    },
                    component: () => import("@/pages/user/Index.vue"),
                },
                {
                    path: "users/create",
                    name: "user.create",
                    meta: {
                        title: "User management",
                        isAuth: true,
                        requiredRole: "ADMIN",
                    },
                    component: () => import("@/pages/user/Create.vue"),
                },
                {
                    path: "users/:id",
                    name: "user.edit",
                    meta: {
                        title: "User management",
                        isAuth: true,
                        requiredRole: "ADMIN",
                    },
                    component: () => import("@/pages/user/Edit.vue"),
                },
                //category
                {
                    path: "categories",
                    name: "category.index",
                    meta: {
                        title: "Category management",
                        isAuth: true,
                        requiredRole: ["ADMIN", "MANAGER"],
                    },
                    component: () => import("@/pages/category/Index.vue"),
                },
                {
                    path: "categories/create",
                    name: "category.create",
                    meta: {
                        title: "Category management",
                        isAuth: true,
                        requiredRole: ["ADMIN", "MANAGER"],
                    },
                    component: () => import("@/pages/category/Create.vue"),
                },
                {
                    path: "categories/:id",
                    name: "category.edit",
                    meta: {
                        title: "Category management",
                        isAuth: true,
                        requiredRole: ["ADMIN", "MANAGER"],
                    },
                    component: () => import("@/pages/category/Edit.vue"),
                },
                //discount
                {
                    path: "discounts",
                    name: "discount.index",
                    meta: {
                        title: "Discount management",
                        isAuth: true,
                        requiredRole: ["ADMIN", "MANAGER"],
                    },
                    component: () => import("@/pages/discount/Index.vue"),
                },
                {
                    path: "discounts/create",
                    name: "discount.create",
                    meta: {
                        title: "Discount management",
                        isAuth: true,
                        requiredRole: ["ADMIN", "MANAGER"],
                    },
                    component: () => import("@/pages/discount/Create.vue"),
                },
                {
                    path: "discounts/:id",
                    name: "discount.edit",
                    meta: {
                        title: "Discount management",
                        isAuth: true,
                        requiredRole: ["ADMIN", "MANAGER"],
                    },
                    component: () => import("@/pages/discount/Edit.vue"),
                },
                //product
                {
                    path: "products",
                    name: "product.index",
                    meta: {
                        title: "Product management",
                        isAuth: true,
                        requiredRole: ["ADMIN", "MANAGER"],
                    },
                    component: () => import("@/pages/product/Index.vue"),
                },
                {
                    path: "products/create",
                    name: "product.create",
                    meta: {
                        title: "Product management",
                        isAuth: true,
                        requiredRole: ["ADMIN", "MANAGER"],
                    },
                    component: () => import("@/pages/product/Create.vue"),
                },
                {
                    path: "products/:id",
                    name: "product.edit",
                    meta: {
                        title: "Product management",
                        isAuth: true,
                        requiredRole: ["ADMIN", "MANAGER"],
                    },
                    component: () => import("@/pages/product/Edit.vue"),
                },
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
                //document
                {
                    path: "documents",
                    name: "document.index",
                    meta: {
                        title: "Document management",
                        isAuth: true,
                        requiredRole: ["SUPPLIER"],
                    },
                    component: () => import("@/pages/document/Index.vue"),
                },
                {
                    path: "documents/create",
                    name: "document.create",
                    meta: {
                        title: "Document management",
                        isAuth: true,
                        requiredRole: ["SUPPLIER"],
                    },
                    component: () => import("@/pages/document/Create.vue"),
                },
                {
                    path: "documents/:id",
                    name: "document.edit",
                    meta: {
                        title: "Document management",
                        isAuth: true,
                        requiredRole: ["SUPPLIER"],
                    },
                    component: () => import("@/pages/document/Edit.vue"),
                },
                // document-approval
                {
                    path: "documents-approval",
                    name: "document-approval.index",
                    meta: {
                        title: "Document management",
                        isAuth: true,
                        requiredRole: ["ADMIN", "MANAGER"],
                    },
                    component: () => import("@/pages/document-approval/Index.vue"),
                },
                //offline-order
                {
                    path: "offline-order",
                    name: "offline-order",
                    meta: {
                        title: "Offline Order",
                        isAuth: true,
                        requiredRole: ["ADMIN", "MANAGER", "STAFF"],
                    },
                    component: () => import("@/pages/offline-order/Index.vue"),
                },
                {
                    path: "offline-order/:storage/create",
                    name: "offline-order.create",
                    meta: {
                        title: "Offline Order",
                        isAuth: true,
                        requiredRole: ["ADMIN", "MANAGER", "STAFF"],
                    },
                    component: () => import("@/pages/offline-order/Create.vue"),
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
