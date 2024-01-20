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
        async getRevenuesByMonth(storage) {
            return request.get('/revenues/month');
        },
    },
});
