import { defineStore } from 'pinia';
import request from '@/utils/request';

export const useDocumentApprovalStore = defineStore('document-approval', {
    state: () => ({
        user: {},
        isAuth: true,
        documents: [],
        pagination: {},
    }),
    getters: {
    },
    actions: {
        async getDocuments(params) {
            try {
                const { data } = await request.get('/documents/all', {
                    params: params
                })
                this.documents = data.data
                this.pagination = {
                    page: data.meta.current_page,
                    rowsPerPage: data.meta.per_page,
                    rowsNumber: data.meta.total,
                };
            } catch (error) {
                throw error
            }
        },
        async getDocument(id) {
            try {
                const response = await request.get(`/documents/${id}`);
                return response.data;
            } catch (error) {
                throw error;
            }
        },
        async getSuppliers() {
            return request.get('/documents/suppliers');
        },
        async approve(id) {
            return request.post(`/documents/approve/${id}`);
        },
        async deny(id) {
            return request.post(`/documents/deny/${id}`);
        },
    },
});
