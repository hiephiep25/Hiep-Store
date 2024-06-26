import { defineStore } from "pinia";
import request from "@/utils/request";

export const useOrderStore = defineStore("order", {
  state: () => ({
    user: {},
    isAuth: true,
  }),
  getters: {},
  actions: {
    async getRevenuesByMonth(year) {
      return request.get("/revenues/month", { params: { year } });
    },

    async getOnlineRevenuesByMonth(year) {
      return request.get("/revenues/online", { params: { year } });
    },

    async getOfflineRevenuesByMonth(year) {
      return request.get("/revenues/offline", { params: { year } });
    },

    async getOfflineRevenuesByStore(year) {
      return request.get("/revenues/by-store", { params: { year } });
    },
  },
});
