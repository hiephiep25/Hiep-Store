import { defineStore } from 'pinia';
import request from '@/utils/request';

export const useNotificationStore = defineStore('notification', {
    state: () => ({
        user: {},
        isAuth: true,
        notifications: [],
        counts: 0,
    }),
    getters: {
    },
    actions: {
        async getNotifications() {
            try {
                const { data } = await request.get('/notifications/list-noti')
                this.notifications = data.notifications
            } catch (error) {
                throw error
            }
        },
        async countUnreadNotifications() {
            try {
                const { data } = await request.get('/notifications/unread-count')
                this.counts = data.count
            } catch (error) {
                throw error
            }
        },
    },
});
