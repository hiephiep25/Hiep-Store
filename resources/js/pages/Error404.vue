<template>
    <div class="fullscreen bg-blue text-white text-center q-pa-md flex flex-center">
        <div>
            <div style="font-size: 30vh">
                404
            </div>

            <div class="text-h2" style="opacity:.4">
                Trang không tìm thấy
            </div>

            <q-btn class="q-mt-xl" color="white" text-color="blue" unelevated @click="goHome" label="Về trang chủ" no-caps />
        </div>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const goHome = () => {
    router.push({ name: 'home' });
};
</script>
