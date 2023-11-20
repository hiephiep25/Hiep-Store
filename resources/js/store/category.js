import { defineStore } from 'pinia';
import request from '@/utils/request';

export const useCategoryStore = defineStore('category', {
  state: () => ({
    user: {},
    isAuth: true,
    categories: [],
    pagination: {},
  }),
  getters: {
  },
  actions: {
    async getCategories(params) {
      try {
        const { data } = await request.get('/categories', {
          params: params
        })
        this.categories = data.data
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
        await request.post('/categories/create', {
          data: formData,
        });
      } catch (error) {
        throw error;
      }
    },
    async getCategory(id) {
      try {
        const response = await request.get(`/categories/${id}`);
        return response.data;
      } catch (error) {
        throw error;
      }
    },
    async updateCategory(id, formData) {
      try {
        await request.post(`/categories/${id}`, {
          data: formData,
        });
      } catch (error) {
        throw error;
      }
    },
    deleteCategory(id) {
      return request.delete(`/categories/${id}`);
    },
  },
});
