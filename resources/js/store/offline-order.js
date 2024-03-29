import { defineStore } from 'pinia';
import request from '@/utils/request';

export const useOfflineOrderStore = defineStore('offlineOrder', {
    state: () => ({
        user: {},
        isAuth: true,
        offlineOrders: [],
        pagination: {},
    }),
    getters: {
    },
    actions: {
        async getOfflineOrders(params) {
            try {
                const { data } = await request.get('/offline-orders', {
                    params: params
                })
                this.offlineOrders = data.data
                this.pagination = {
                    page: data.meta.current_page,
                    rowsPerPage: data.meta.per_page,
                    rowsNumber: data.meta.total,
                };
            } catch (error) {
                throw error
            }
        },
        async getStoreProductCodes(store) {
            return request.get(`/offline-orders/store-product/${store}`);
        },
        async getDetailOfflineOrder(id) {
            return request.get(`/offline-orders/${id}`);
        },
        async create(formData, store) {
            try {
                await request.post(`/offline-orders/${store}/create`, {
                    data: formData,
                });
            } catch (error) {
                throw error;
            }
        },
    },
});
