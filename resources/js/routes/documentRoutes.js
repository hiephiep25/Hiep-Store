const documentRoutes = [
    {
        path: "documents",
        name: "document.index",
        meta: {
            title: "Document management",
            isAuth: true,
            requiredRole: ["SUPPLIER"],
        },
        component: () => import("@/pages/document/Index.vue"),
    },
    {
        path: "documents/create",
        name: "document.create",
        meta: {
            title: "Document management",
            isAuth: true,
            requiredRole: ["SUPPLIER"],
        },
        component: () => import("@/pages/document/Create.vue"),
    },
    {
        path: "documents/:id",
        name: "document.edit",
        meta: {
            title: "Document management",
            isAuth: true,
            requiredRole: ["SUPPLIER"],
        },
        component: () => import("@/pages/document/Edit.vue"),
    },
    {
        path: "documents-approval",
        name: "document-approval.index",
        meta: {
            title: "Document management",
            isAuth: true,
            requiredRole: ["ADMIN", "MANAGER"],
        },
        component: () => import("@/pages/document-approval/Index.vue"),
    },
];

export default documentRoutes;
