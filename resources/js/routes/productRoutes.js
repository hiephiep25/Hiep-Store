const productRoutes = [
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
];

export default productRoutes;
