const managerRoutes = [
    {
        path: "managers",
        name: "manager.index",
        meta: {
            title: "Quản lí người quản lí",
            isAuth: true,
            requiredRole: ["ADMIN"],
        },
        component: () => import("@/pages/manager/Index.vue"),
    },
];

export default managerRoutes;
