import { defineStore } from 'pinia';
import request from '@/utils/request';

export const useProductStore = defineStore('product', {
  state: () => ({
    user: {},
    isAuth: true,
    products: [],
    pagination: {},
  }),
  getters: {
  },
  actions: {
    async getProducts(params) {
      try {
        const { data } = await request.get('/products', {
          params: params
        })
        this.products = data.data
        this.pagination = {
          page: data.meta.current_page,
          rowsPerPage: data.meta.per_page,
          rowsNumber: data.meta.total,
        };
      } catch (error) {
        throw error
      }
    },
    async getCategories() {
        return request.get('/products/categories');
    },
    async create(formData) {
      try {
        await request.post('/products/create', {
          data: formData,
        });
      } catch (error) {
        throw error;
      }
    },
    async getProduct(id) {
      try {
        const response = await request.get(`/products/${id}`);
        return response.data;
      } catch (error) {
        throw error;
      }
    },
    async updateProduct(id, formData) {
      try {
        await request.post(`/products/${id}`, {
          data: formData,
        });
      } catch (error) {
        throw error;
      }
    },
    deleteProduct(id) {
      return request.delete(`/products/${id}`);
    },
  },
});
