import { defineStore } from 'pinia';
import request from '@/utils/request';

export const useDiscountStore = defineStore('discount', {
  state: () => ({
    user: {},
    isAuth: true,
    discounts: [],
    pagination: {},
  }),
  getters: {
  },
  actions: {
    async getDiscounts(params) {
      try {
        const { data } = await request.get('/discounts', {
          params: params
        })
        this.discounts = data.data
        this.pagination = {
          page: data.meta.current_page,
          rowsPerPage: data.meta.per_page,
          rowsNumber: data.meta.total,
        };
      } catch (error) {
        throw error
      }
    },
    async create(formData) {
      try {
        await request.post('/discounts/create', {
          data: formData,
        });
      } catch (error) {
        throw error;
      }
    },
    async getDiscount(id) {
      try {
        const response = await request.get(`/discounts/${id}`);
        return response.data;
      } catch (error) {
        throw error;
      }
    },
    async updateDiscount(id, formData) {
      try {
        await request.post(`/discounts/${id}`, {
          data: formData,
        });
      } catch (error) {
        throw error;
      }
    },
    deleteDiscount(id) {
      return request.delete(`/discounts/${id}`);
    },
  },
});
