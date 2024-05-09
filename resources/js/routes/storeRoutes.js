const storeRoutes = [
    {
        path: "admin-stores",
        name: "admin-store.index",
        meta: {
            title: "Quản lí cửa hàng",
            isAuth: true,
            requiredRole: ["ADMIN"],
        },
        component: () => import("@/pages/store/Index.vue"),
    },
    {
        path: "admin-stores/create",
        name: "admin-store.create",
        meta: {
            title: "Quản lí cửa hàng",
            isAuth: true,
            requiredRole: ["ADMIN"],
        },
        component: () => import("@/pages/store/Create.vue"),
    },
    {
        path: "admin-stores/:id",
        name: "admin-store.edit",
        meta: {
            title: "Quản lí cửa hàng",
            isAuth: true,
            requiredRole: ["ADMIN"],
        },
        component: () => import("@/pages/store/Edit.vue"),
    },
];

export default storeRoutes;
