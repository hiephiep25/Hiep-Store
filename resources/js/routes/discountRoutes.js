const discountRoutes = [
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
];

export default discountRoutes;
