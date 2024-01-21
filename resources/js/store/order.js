import { defineStore } from 'pinia';
import request from '@/utils/request';

export const useOrderStore = defineStore('order', {
    state: () => ({
        user: {},
        isAuth: true,
    }),
    getters: {
    },
    actions: {
        async getRevenuesByMonth(year) {
            return request.get('/revenues/month', { params: { year } });
        },
    },
});
