const userRoutes = [
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
];

export default userRoutes;
