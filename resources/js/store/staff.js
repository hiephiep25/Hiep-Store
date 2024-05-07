import { defineStore } from 'pinia';
import request from '@/utils/request';

export const useStaffStore = defineStore('staff', {
  state: () => ({
    user: {},
    isAuth: true,
    staffs: [],
    pagination: {},
  }),
  getters: {
  },
  actions: {
    async getStaffs(params) {
      try {
        const { data } = await request.get('/staffs', {
          params: params
        })
        this.staffs = data.data
        this.pagination = {
          page: data.meta.current_page,
          rowsPerPage: data.meta.per_page,
          rowsNumber: data.meta.total,
        };
      } catch (error) {
        throw error
      }
    },
    async getStaff(id) {
      try {
        const response = await request.get(`/staffs/${id}`);
        return response.data;
      } catch (error) {
        throw error;
      }
    },
    async updateStaff(id, formData) {
      try {
        await request.post(`/staffs/${id}`, {
          data: formData,
        });
      } catch (error) {
        throw error;
      }
    },
  },
});
