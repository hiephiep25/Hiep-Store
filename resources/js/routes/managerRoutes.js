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
  {
    path: "managers/:id",
    name: "manager.edit",
    meta: {
      title: "Quản lí người quản lí",
      isAuth: true,
      requiredRole: ["ADMIN"],
    },
    component: () => import("@/pages/manager/Edit.vue"),
  },
];

export default managerRoutes;
