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
];

export default staffRoutes;
