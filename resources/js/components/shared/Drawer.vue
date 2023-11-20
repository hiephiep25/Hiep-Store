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
                    v-for="content in drawerContent.filter((d) => d.show)"
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
            @click="redirectLandingPage"
        >
            <div
                class="bg-transparent row column items-center full-height full-width justify-center"
            >
                <q-avatar size="64px">
                    <img src="@/public/images/icon.png" />HiepStore
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
            label: "Home",
            icon: "home",
            active: /home/g.test(route.name.toString()),
            action: () => router.push({ name: "home" }),
            show: true,
        },
        {
            label: "User management",
            icon: "group",
            active: /user/g.test(route.name.toString()),
            action: () => router.push({ name: "user.index" }),
            show: user.value.role === "ADMIN",
        },
        {
            label: "Category management",
            icon: "category",
            active: /category/g.test(route.name.toString()),
            action: () => router.push({ name: "category.index" }),
            show: true
        },
        {
            label: "Change password",
            icon: "key",
            active: /change-password/g.test(route.name.toString()),
            action: () => router.push({ name: "change-password" }),
            show: true,
        },
    ];
});
</script>