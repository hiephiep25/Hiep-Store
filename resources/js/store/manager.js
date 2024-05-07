import { defineStore } from 'pinia';
import request from '@/utils/request';

export const useManagerStore = defineStore('manager', {
  state: () => ({
    user: {},
    isAuth: true,
    managers: [],
    pagination: {},
  }),
  getters: {
  },
  actions: {
    async getManagers(params) {
      try {
        const { data } = await request.get('/managers', {
          params: params
        })
        this.managers = data.data
        this.pagination = {
          page: data.meta.current_page,
          rowsPerPage: data.meta.per_page,
          rowsNumber: data.meta.total,
        };
      } catch (error) {
        throw error
      }
    },
    async getManager(id) {
      try {
        const response = await request.get(`/managers/${id}`);
        return response.data;
      } catch (error) {
        throw error;
      }
    },
    async updateManager(id, formData) {
      try {
        await request.post(`/managers/${id}`, {
          data: formData,
        });
      } catch (error) {
        throw error;
      }
    },
  },
});
