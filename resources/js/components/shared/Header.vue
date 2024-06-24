<template>
  <q-header elevated class="bg-primary text-white">
    <q-toolbar>
      <q-btn dense flat round icon="menu" @click="$emit('toggleLeftDrawer')" />
      <q-toolbar-title>{{ $route.meta.title }}</q-toolbar-title>
      <q-space></q-space>
      <q-btn
        dense
        flat
        round
        :class="{ 'bg-red-7 text-white': counts > 0 }"
        class="position-relative"
      >
        <q-icon name="notifications" />
        <span v-if="counts > 0" class="badge bg-white text-red-7">{{
          counts
        }}</span>
        <q-menu transition-show="scale" transition-hide="scale">
          <q-list>
            <q-item
              v-for="(notification, index) in notifications"
              :key="index"
              clickable
              @click="navigateToNotification(notification)"
            >
              <q-item-section>
                <span
                  :class="{ 'text-grey-7': notification.is_read }"
                  class="row"
                  style="align-items: center"
                >
                  <div class="row" style="width: 200px">
                    <b>{{
                      notification.sender_id
                        ? notification.sender.name
                        : "Hệ thống:"
                    }}</b>
                    <div class="q-ml-xs">{{ notification.content }}</div>
                  </div>
                  <span
                    class="status-dot q-ml-sm"
                    :class="{
                      'bg-blue': !notification.is_read,
                      'bg-grey': notification.is_read,
                    }"
                  ></span>
                </span>
              </q-item-section>
            </q-item>
          </q-list>
        </q-menu>
      </q-btn>
      <q-btn-dropdown
        class="q-ml-sm"
        unelevated
        no-caps
        :label="user.name"
        icon="perm_identity"
      >
        <q-list>
          <q-item
            clickable
            v-close-popup
            v-for="(item, key) in dropdownItems"
            :key="key"
            @click="item.onClick"
          >
            <q-item-section>
              <q-item-label>{{ item.label }}</q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </q-btn-dropdown>
    </q-toolbar>
  </q-header>
</template>

<script setup>
import { useAuthStore } from "@/store/auth";
import { storeToRefs } from "pinia";
import { useRouter } from "vue-router";
import { useNotificationStore } from "@/store/notification";
import { onMounted, ref } from "vue";
const env = import.meta.env;
const authStore = useAuthStore();
const { user } = storeToRefs(authStore);
const router = useRouter();
const notificationStore = useNotificationStore();
const { counts, notifications } = storeToRefs(notificationStore);

const dropdownItems = [
  {
    label: "Thông tin cá nhân",
    onClick: () => {
      router.push({ name: "profile" });
    },
  },
  {
    label: "Đổi mật khẩu",
    onClick: () => {
      router.push({ name: "change-password" });
    },
  },
  {
    label: "Đăng xuất",
    onClick: () => {
      authStore.useLogout();
    },
  },
];

const navigateToNotification = async (notification) => {
  // console.log(env.VITE_APP_URL)
  const appUrl = env.VITE_APP_URL;
  const redirectUrl = `${appUrl}/${notification.redirect}`;
  await notificationStore.readNotification(notification.id);
  window.location.replace(redirectUrl);
};

onMounted(async () => {
  await notificationStore.countUnreadNotifications();
  await notificationStore.getNotifications();
});
</script>

<style scoped>
.badge {
  position: absolute;
  top: -2px;
  right: -6px;
  font-size: 12px;
  font-weight: bold;
  width: 16px;
  height: 16px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.status-dot {
  display: inline-block;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  margin-right: 8px;
}

.bg-blue {
  background-color: blue;
}

.bg-grey {
  background-color: grey;
}

.text-grey-7 {
  color: rgba(0, 0, 0, 0.54);
}
</style>
