import { defineStore } from 'pinia';
import request from '@/utils/request';

export const useStorageStore = defineStore('storage', {
  state: () => ({
    user: {},
    isAuth: true,
    storages: [],
    pagination: {},
  }),
  getters: {
  },
  actions: {
    async getStorages() {
      try {
        const { data } = await request.get('/storages', {
        })
        this.storages = data.data
      } catch (error) {
        throw error
      }
    },
    async updateStorages(formData) {
      try {
        await request.post('/storages/store', {
          data: formData,
        });
      } catch (error) {
        throw error;
      }
    },
  },
});
