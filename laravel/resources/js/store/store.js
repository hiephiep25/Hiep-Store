import { defineStore } from "pinia";
import request from "@/utils/request";

export const useStoreStore = defineStore("store", {
  state: () => ({
    user: {},
    isAuth: true,
    stores: [],
    productStores: [],
    pagination: {},
  }),
  getters: {},
  actions: {
    async getStores(params) {
      try {
        const { data } = await request.get("/stores", {
          params: params,
        });
        this.stores = data.data;
        this.pagination = {
          page: data.meta.current_page,
          rowsPerPage: data.meta.per_page,
          rowsNumber: data.meta.total,
        };
      } catch (error) {
        throw error;
      }
    },
    async getProductStores(params) {
      try {
        const { data } = await request.get("/stores/products", {
          params: params,
        });
        this.productStores = data.data;
        this.pagination = {
          page: data.meta.current_page,
          rowsPerPage: data.meta.per_page,
          rowsNumber: data.meta.total,
        };
      } catch (error) {
        throw error;
      }
    },
    async updateProductStores(formData) {
      try {
        await request.post("/store-product", {
          data: formData,
        });
      } catch (error) {
        throw error;
      }
    },
    async create(formData) {
      try {
        await request.post("/stores/create", {
          data: formData,
        });
      } catch (error) {
        throw error;
      }
    },
    async getStore(id) {
      try {
        const response = await request.get(`/stores/${id}`);
        return response.data;
      } catch (error) {
        throw error;
      }
    },
    async updateStore(id, formData) {
      try {
        await request.post(`/stores/${id}`, {
          data: formData,
        });
      } catch (error) {
        throw error;
      }
    },
  },
});
