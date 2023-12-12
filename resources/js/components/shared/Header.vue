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

const authStore = useAuthStore();
const { user } = storeToRefs(authStore);
const router = useRouter();

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
</script>
