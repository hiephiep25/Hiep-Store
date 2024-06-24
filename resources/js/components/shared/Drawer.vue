<template>
  <q-drawer show-if-above v-model="drawer" side="left" bordered>
    <q-scroll-area
      :style="{
        height: `calc(100% - ${headerHeight})`,
        marginTop: headerHeight,
      }"
    >
      <q-list padding>
        <q-item
          v-for="content in drawerContent.filter(
            (d) => d.label === 'Trang chủ'
          )"
          :class="{ 'bg-primary text-white': content.active }"
          :active="content.active"
          :key="content.label"
          v-ripple
          clickable
          @click="content.action"
        >
          <q-item-section avatar>
            <q-icon :name="content.icon" />
          </q-item-section>

          <q-item-section>{{ content.label }}</q-item-section>
        </q-item>

        <q-expansion-item
          v-for="group in drawerGroups.filter((g) => g.show)"
          :key="group.label"
          :label="group.label"
          :icon="group.icon"
        >
          <q-list class="q-ml-lg">
            <q-item
              v-for="content in group.items.filter((d) => d.show)"
              :class="{ 'bg-primary text-white': content.active }"
              :active="content.active"
              :key="content.label"
              v-ripple
              clickable
              @click="content.action"
            >
              <q-item-section avatar>
                <q-icon :name="content.icon" />
              </q-item-section>

              <q-item-section>{{ content.label }}</q-item-section>
            </q-item>
          </q-list>
        </q-expansion-item>
        <q-item
          v-for="content in drawerContent.filter(
            (d) => d.show && d.label !== 'Trang chủ'
          )"
          :class="{ 'bg-primary text-white': content.active }"
          :active="content.active"
          :key="content.label"
          v-ripple
          clickable
          @click="content.action"
        >
          <q-item-section avatar>
            <q-icon :name="content.icon" />
          </q-item-section>

          <q-item-section>{{ content.label }}</q-item-section>
        </q-item>
      </q-list>
    </q-scroll-area>
    <q-img
      class="absolute-top cursor-pointer"
      :style="{
        height: headerHeight,
      }"
    >
      <div
        class="bg-transparent row column items-center full-height full-width justify-center"
      >
        <q-avatar size="64px">
          <template v-if="user.avatar">
            <img :src="user.avatar" alt="User Avatar" />
          </template>
          <template v-else>
            <img src="@/public/images/avatar.jpg" alt="Default Avatar" />
          </template>
          {{ user.name }}
        </q-avatar>
      </div>
    </q-img>
  </q-drawer>
</template>

<script setup>
import { computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useAuthStore } from "@/store/auth";
import { storeToRefs } from "pinia";

const headerHeight = "75px";

const authStore = useAuthStore();
const { user } = storeToRefs(authStore);

const props = defineProps({
  drawer: {
    type: Boolean,
    required: true,
  },
});
const emit = defineEmits(["update:drawer"]);

const router = useRouter();
const route = useRoute();

const drawer = computed({
  get() {
    return props.drawer;
  },
  set(value) {
    emit("update:drawer", value);
  },
});

const drawerContent = computed(() => {
  return [
    {
      label: "Trang chủ",
      icon: "home",
      active: /home/g.test(route.name.toString()),
      action: () => router.push({ name: "home" }),
      show: true,
    },
    {
      label: "Sản phẩm trong cửa hàng",
      icon: "shop",
      active: /shop/g.test(route.name.toString()),
      action: () => router.push({ name: "shop" }),
      show:
        user.value.role === "ADMIN" ||
        user.value.role === "MANAGER" ||
        user.value.role === "STAFF",
    },
    {
      label: "Danh mục sản phẩm",
      icon: "category",
      active: /category/g.test(route.name.toString()),
      action: () => router.push({ name: "category.index" }),
      show: user.value.role === "ADMIN",
    },
    {
      label: "Khuyến mãi",
      icon: "discount",
      active: /discount/g.test(route.name.toString()),
      action: () => router.push({ name: "discount.index" }),
      show: user.value.role === "ADMIN",
    },
    {
      label: "Sản phẩm",
      icon: "fastfood",
      active: /product/g.test(route.name.toString()),
      action: () => router.push({ name: "product.index" }),
      show: user.value.role === "ADMIN",
    },
    {
      label: "Tài liệu cung cấp",
      icon: "description",
      active: /document/g.test(route.name.toString()),
      action: () => router.push({ name: "document.index" }),
      show: user.value.role === "SUPPLIER",
    },
    {
      label: "Quản lí tài liệu cung cấp",
      icon: "description",
      active: /document-approval/g.test(route.name.toString()),
      action: () => router.push({ name: "document-approval.index" }),
      show: user.value.role === "ADMIN",
    },
    {
      label: "Đơn hàng tại quầy",
      icon: "shopping_cart",
      active: /offline-order/g.test(route.name.toString()),
      action: () => router.push({ name: "offline-order" }),
      show:
        user.value.role === "MANAGER" ||
        user.value.role === "STAFF" ||
        user.value.role === "ADMIN",
    },
    {
      label: "Đơn hàng trực tuyến",
      icon: "shopping_cart_checkout",
      active: /online-order/g.test(route.name.toString()),
      action: () => router.push({ name: "online-order" }),
      show:
        user.value.role === "MANAGER" ||
        user.value.role === "STAFF" ||
        user.value.role === "ADMIN",
    },
    {
      label: "Lựa chọn xử lí",
      icon: "settings",
      active: /process/g.test(route.name.toString()),
      action: () => router.push({ name: "process.index" }),
      show: user.value.role === "MANAGER" || user.value.role === "ADMIN",
    },
  ];
});

const drawerGroups = computed(() => {
  return [
    {
      label: "Quản lí nhân viên",
      icon: "group",
      show: user.value.role === "ADMIN" || user.value.role === "MANAGER",
      items: [
        {
          label: "User",
          icon: "person",
          active: /user/g.test(route.name.toString()),
          action: () => router.push({ name: "user.index" }),
          show: user.value.role === "ADMIN",
        },
        {
          label: "Người quản lí",
          icon: "person",
          active: /manager/g.test(route.name.toString()),
          action: () => router.push({ name: "manager.index" }),
          show: user.value.role === "ADMIN",
        },
        {
          label: "Nhân viên",
          icon: "person",
          active: /staff/g.test(route.name.toString()),
          action: () => router.push({ name: "staff.index" }),
          show: user.value.role === "ADMIN" || user.value.role === "MANAGER",
        },
      ],
    },
  ];
});
</script>
