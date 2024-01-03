import { defineStore } from 'pinia';
import request from '@/utils/request';

export const useDocumentStore = defineStore('document', {
    state: () => ({
        user: {},
        isAuth: true,
        documents: [],
        pagination: {},
    }),
    getters: {
    },
    actions: {
        async getMyDocuments(params) {
            try {
                const { data } = await request.get('/documents', {
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
        async create(formData) {
            try {
                await request.post('/documents/create', {
                    data: formData,
                });
            } catch (error) {
                throw error;
            }
        },
        async getDocument(id) {
            try {
                const response = await request.get(`/documents/my/${id}`);
                return response.data;
            } catch (error) {
                throw error;
            }
        },
        async updateDocument(id, formData) {
            try {
                await request.post(`/documents/${id}`, {
                    data: formData,
                });
            } catch (error) {
                throw error;
            }
        },
        deleteDocument(id) {
            return request.delete(`/documents/${id}`);
        },
    },
});
