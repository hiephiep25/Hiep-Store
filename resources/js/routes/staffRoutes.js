const staffRoutes = [
    {
        path: "staffs",
        name: "staff.index",
        meta: {
            title: "Quản lí nhân viên",
            isAuth: true,
            requiredRole: ["ADMIN", "MANAGER"],
        },
        component: () => import("@/pages/staff/Index.vue"),
    },
    {
        path: "staffs/:id",
        name: "staff.edit",
        meta: {
            title: "Quản lí nhân viên",
            isAuth: true,
            requiredRole: ["ADMIN", "MANAGER"],
        },
        component: () => import("@/pages/staff/Edit.vue"),
    },
];

export default staffRoutes;
