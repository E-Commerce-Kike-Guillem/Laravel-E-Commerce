import { defineStore } from 'pinia';
import http from '../services/http';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
  }),
  
  getters: {
    isAuthenticated: (state) => !!state.user,
  },
  
  actions: {
    async login(credentials) {
      await http.get('http://localhost/sanctum/csrf-cookie');
      
      const response = await http.post('/login', credentials);
      this.user = response.data;
    },
    
    async logout() {
      await http.post('/logout');
      this.user = null;
    },

    async fetchUser() {
      try {
        const response = await http.get('/user');
        this.user = response.data;
      } catch (error) {
        this.user = null; 
      }
    },
    
    async register(userData) {
      await http.get('http://localhost/sanctum/csrf-cookie');
      
      const response = await http.post('/register', userData);
      
      this.user = response.data;
    }
  },
  
  persist: true
});