<template>
    <q-layout view="lHh LpR fFf">
      <Header @toggleLeftDrawer="toggleLeftDrawer" />

      <Drawer v-model:drawer="drawer" v-if="drawer" />

      <q-page-container>
        <router-view />
      </q-page-container>
    </q-layout>
  </template>

  <script setup>
  import Drawer from '@/components/shared/Drawer.vue';
  import Header from '@/components/shared/Header.vue';
  import { ref } from 'vue';
  import { useRoute } from "vue-router";

  const drawer = ref(true);
  const route = useRoute();

  const toggleLeftDrawer = () => {
    drawer.value = !drawer.value;
  };

  </script>
