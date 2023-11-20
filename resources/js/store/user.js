import { defineStore } from 'pinia';
import request from '@/utils/request';

export const useUserStore = defineStore('user', {
  state: () => ({
    user: {},
    isAuth: true,
    users: [],
    pagination: {},
  }),
  getters: {
  },
  actions: {
    async getUsers(params) {
      try {
        const { data } = await request.get('/users', {
          params: params
        })
        this.users = data.data
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
        await request.post('/users/create', {
          data: formData,
        });
      } catch (error) {
        throw error;
      }
    },
    async getUser(id) {
      try {
        const response = await request.get(`/users/${id}`);
        return response.data;
      } catch (error) {
        throw error;
      }
    },
    async updateUser(id, formData) {
      try {
        await request.post(`/users/${id}`, {
          data: formData,
        });
      } catch (error) {
        throw error;
      }
    },
    deleteUser(id) {
      return request.delete(`/users/${id}`);
    },
  },
});
