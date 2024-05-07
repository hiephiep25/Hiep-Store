const productRoutes = [
    {
        path: "products",
        name: "product.index",
        meta: {
            title: "Quản lí sản phẩm",
            isAuth: true,
            requiredRole: ["ADMIN", "MANAGER"],
        },
        component: () => import("@/pages/product/Index.vue"),
    },
    {
        path: "products/create",
        name: "product.create",
        meta: {
            title: "Quản lí sản phẩm",
            isAuth: true,
            requiredRole: ["ADMIN", "MANAGER"],
        },
        component: () => import("@/pages/product/Create.vue"),
    },
    {
        path: "products/:id",
        name: "product.edit",
        meta: {
            title: "Quản lí sản phẩm",
            isAuth: true,
            requiredRole: ["ADMIN", "MANAGER"],
        },
        component: () => import("@/pages/product/Edit.vue"),
    },
];

export default productRoutes;
