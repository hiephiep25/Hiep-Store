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
    async getStorages(params) {
      try {
        const { data } = await request.get('/storages', {
            params: params
        })
        this.storages = data.data
        this.pagination = {
            page: data.meta.current_page,
            rowsPerPage: data.meta.per_page,
            rowsNumber: data.meta.total,
          };
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
