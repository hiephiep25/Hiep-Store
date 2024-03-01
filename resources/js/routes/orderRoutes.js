const orderRoutes = [
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
        path: "offline-order/:store/create",
        name: "offline-order.create",
        meta: {
            title: "Offline Order",
            isAuth: true,
            requiredRole: ["ADMIN", "MANAGER", "STAFF"],
        },
        component: () => import("@/pages/offline-order/Create.vue"),
    },
    {
        path: "offline-order/:id",
        name: "offline-order.detail",
        meta: {
            title: "Offline Order",
            isAuth: true,
            requiredRole: ["ADMIN", "MANAGER", "STAFF"],
        },
        component: () => import("@/pages/offline-order/Detail.vue"),
    },
];

export default orderRoutes;
