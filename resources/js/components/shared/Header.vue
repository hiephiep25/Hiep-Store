<template>
    <q-header elevated class="bg-primary text-white">
        <q-toolbar>
            <q-btn
                dense
                flat
                round
                icon="menu"
                @click="$emit('toggleLeftDrawer')"
            />
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
                <span v-if="counts > 0" class="badge bg-white text-red-7">{{ counts }}</span>
                <q-menu transition-show="scale" transition-hide="scale">
                    <q-list>
                        <q-item v-for="(notification, index) in notifications" :key="index" clickable>
                        <q-item-section>
                            <b>{{ notification.sender.name }}</b>{{ notification.content }}
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
import { onMounted, ref } from 'vue';

const authStore = useAuthStore();
const { user } = storeToRefs(authStore);
const router = useRouter();
const notificationStore = useNotificationStore();
const { counts, notifications } = storeToRefs(notificationStore);

const dropdownItems = [
    {
        label: "Profile",
        onClick: () => {
            router.push({ name: "profile" });
        },
    },
    {
        label: "Change password",
        onClick: () => {
            router.push({ name: "change-password" });
        },
    },
    {
        label: "Log out",
        onClick: () => {
            authStore.useLogout();
        },
    },
];
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
</style>
