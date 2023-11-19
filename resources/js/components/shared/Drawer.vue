<template>
    <q-drawer show-if-above v-model="drawer" side="left" bordered>
        <q-scroll-area :style="{
            height: `calc(100% - ${headerHeight})`,
            marginTop: headerHeight,
        }">
            <q-list padding>
                <q-item v-for="content in drawerContent.filter(d => d.show)"
                    :class="{ 'bg-secondary text-white': content.active }" :active="content.active" :key="content.label"
                    v-ripple clickable @click="content.action">
                    <q-item-section avatar>
                        <q-icon :name="content.icon" />
                    </q-item-section>

                    <q-item-section>{{ content.label }}</q-item-section>
                </q-item>
            </q-list>
        </q-scroll-area>
        <q-img class="absolute-top cursor-pointer" :style="{
            height: headerHeight,
        }" @click="redirectLandingPage">
            <div class="bg-transparent row column items-center full-height full-width justify-center">
                <q-avatar size="96px">
                    <img src="@/public/images/icon.jpg" />HiepStore
                </q-avatar>
            </div>
        </q-img>
    </q-drawer>
</template>
<script setup>
import { computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '@/store/auth';
import { storeToRefs } from 'pinia';

const headerHeight = '75px';

const authStore = useAuthStore();
const { user } = storeToRefs(authStore);

const props = defineProps({
    drawer: {
        type: Boolean,
        required: true,
    },
});
const emit = defineEmits(['update:drawer']);

const router = useRouter();
const route = useRoute();

const drawer = computed({
    get() {
        return props.drawer;
    },
    set(value) {
        emit('update:drawer', value);
    },
});

const drawerContent = computed(() => {
    return [

    ];
});
</script>
