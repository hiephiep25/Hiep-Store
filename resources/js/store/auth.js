import { defineStore } from 'pinia';
import request from '@/utils/request';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    isAuth: false,
    isCalled: false,
    isAdmin: false,
  }),
  getters: {
  },
  actions: {
    async login(formData) {
      try {
        await request.post('/login', {
          data: formData,
        });
        await this.getLoginUser();
        this.isAuth = true;
      } catch (error) {
        throw error;
      }
    },
    async getLoginUser() {
      try {
        const { data } = await request.get('/profile');
        console.log(data);
        this.user = data;
        if(this.user.role === 'ADMIN'){
            this.isAdmin = true;
          }
      } catch (error) {
        throw error;
      }
    },
    async verify() {
      try {
        if (!this.isCalled) {
          const { data } = await request.get('/verify');
          if (data.is_login) {
            await this.getLoginUser()
          }
          this.isAuth = data.is_login;
        }
      } catch (error) {
        throw error;
      } finally {
        this.isCalled = true;
      }
    },
    async logout() {
      await request.get('/logout');
      this.user = null;
      this.isAuth = false;
      this.isCalled = false;
    },
    async useLogout() {
      await this.logout();
      window.location.replace('/login');
    },
  },
});
