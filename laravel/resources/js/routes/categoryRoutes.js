const categoryRoutes = [
  {
    path: "categories",
    name: "category.index",
    meta: {
      title: "Quản lí danh mục",
      isAuth: true,
      requiredRole: ["ADMIN", "MANAGER"],
    },
    component: () => import("@/pages/category/Index.vue"),
  },
  // {
  //   path: "categories/create",
  //   name: "category.create",
  //   meta: {
  //     title: "Quản lí danh mục",
  //     isAuth: true,
  //     requiredRole: ["ADMIN", "MANAGER"],
  //   },
  //   component: () => import("@/pages/category/Create.vue"),
  // },
  // {
  //   path: "categories/:id",
  //   name: "category.edit",
  //   meta: {
  //     title: "Quản lí danh mục",
  //     isAuth: true,
  //     requiredRole: ["ADMIN", "MANAGER"],
  //   },
  //   component: () => import("@/pages/category/Edit.vue"),
  // },
];

export default categoryRoutes;
