import { defineStore } from 'pinia';
import request from '@/utils/request';

export const useProcessStore = defineStore('process', {
  state: () => ({
    user: {},
    isAuth: true,
    processes: [],
    pagination: {},
  }),
  getters: {
  },
  actions: {
    async getProcesses(params) {
      try {
        const { data } = await request.get('/process', {
          params: params
        })
        this.processes = data.data
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
            await request.post(`/process/create`, {
                data: formData,
            });
        } catch (error) {
            throw error;
        }
    },
    async getProcess(id) {
      try {
        const response = await request.get(`/process/${id}`);
        return response.data;
      } catch (error) {
        throw error;
      }
    },
    // async updateProcess(id, formData) {
    //   try {
    //     await request.post(`/process/${id}`, {
    //       data: formData,
    //     });
    //   } catch (error) {
    //     throw error;
    //   }
    // },
  },
});
