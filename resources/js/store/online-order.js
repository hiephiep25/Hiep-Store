import { defineStore } from 'pinia';
import request from '@/utils/request';

export const useOnlineOrderStore = defineStore('onlineOrder', {
    state: () => ({
        user: {},
        isAuth: true,
        onlineOrders: [],
        pagination: {},
    }),
    getters: {
    },
    actions: {
        async getOnlineOrders(params) {
            try {
                const { data } = await request.get('/online-orders', {
                    params: params
                })
                this.onlineOrders = data.data
                this.pagination = {
                    page: data.meta.current_page,
                    rowsPerPage: data.meta.per_page,
                    rowsNumber: data.meta.total,
                };
            } catch (error) {
                throw error
            }
        },
        async getDetailOnlineOrder(id) {
            return request.get(`/online-orders/${id}`);
        },
    },
});
