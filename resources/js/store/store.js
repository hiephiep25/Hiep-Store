import { defineStore } from 'pinia';
import request from '@/utils/request';

export const useStoreStore = defineStore('store', {
  state: () => ({
    user: {},
    isAuth: true,
    stores: [],
    pagination: {},
  }),
  getters: {
  },
  actions: {
    async getStores(params) {
      try {
        const { data } = await request.get('/stores', {
            params: params
        })
        this.stores = data.data
        this.pagination = {
            page: data.meta.current_page,
            rowsPerPage: data.meta.per_page,
            rowsNumber: data.meta.total,
          };
      } catch (error) {
        throw error
      }
    },
    async updateStores(formData) {
      try {
        await request.post('/stores/store', {
          data: formData,
        });
      } catch (error) {
        throw error;
      }
    },
  },
});
