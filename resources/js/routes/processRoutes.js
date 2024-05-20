const processRoutes = [
    {
        path: "process",
        name: "process.index",
        meta: {
            title: "Quản lí lựa chọn xử lý",
            isAuth: true,
            requiredRole: ["ADMIN", "MANAGER"],
        },
        component: () => import("@/pages/process/Index.vue"),
    },
    {
        path: "process/create",
        name: "process.create",
        meta: {
            title: "Quản lí lựa chọn xử lý",
            isAuth: true,
            requiredRole: ["ADMIN", "MANAGER"],
        },
        component: () => import("@/pages/process/Create.vue"),
    },
    {
        path: "process/:id",
        name: "process.edit",
        meta: {
            title: "Quản lí lựa chọn xử lý",
            isAuth: true,
            requiredRole: ["ADMIN", "MANAGER"],
        },
        component: () => import("@/pages/process/Edit.vue"),
    },
];

export default processRoutes;
