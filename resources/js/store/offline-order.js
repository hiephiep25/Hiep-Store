import { defineStore } from "pinia";
import request from "@/utils/request";

export const useOfflineOrderStore = defineStore("offlineOrder", {
  state: () => ({
    user: {},
    isAuth: true,
    offlineOrders: [],
    pagination: {},
  }),
  getters: {},
  actions: {
    async getOfflineOrders(params) {
      try {
        const { data } = await request.get("/offline-orders", {
          params: params,
        });
        this.offlineOrders = data.data;
        this.pagination = {
          page: data.meta.current_page,
          rowsPerPage: data.meta.per_page,
          rowsNumber: data.meta.total,
        };
      } catch (error) {
        throw error;
      }
    },
    async getStoreProductCodes(params) {
      return request.get("/offline-orders/products", {
        params: params,
      });
    },
    async getDetailOfflineOrder(id) {
      return request.get(`/offline-orders/${id}`);
    },
    async create(formData) {
      try {
        await request.post(`/offline-orders/create`, {
          data: formData,
        });
      } catch (error) {
        throw error;
      }
    },
  },
});
