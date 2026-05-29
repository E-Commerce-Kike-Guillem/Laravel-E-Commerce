import { defineStore } from "pinia";
import http from "../services/http";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: null,
  }),
  
  getters: {
    // Si necesitas lógica, usa un getter
    isLoggedIn: (state) => !!state.user,
    isAuthenticated: (state) => !!state.user,
  },

  actions: {
    async login(credentials) {
      // 1. Llamada al proxy configurado en vite.config.ts
      await http.get("/sanctum/csrf-cookie"); 
      
      const response = await http.post("/login", credentials);
      this.user = response.data;
      this.isAuthenticated = true;
    },

    async logout() {
      await http.post("/logout");
      this.user = null;
    },

    async fetchUser() {
      try {
        // Al tener baseURL: '/api' en http.js, esto se traduce a /api/user
        const response = await http.get("/user");
        this.user = response.data;
        this.isAuthenticated = true;
      } catch (error) {
        this.user = null;
        this.isAuthenticated = false;
      }
    },

    async register(userData) {
      await http.get("http://localhost/sanctum/csrf-cookie");

      const response = await http.post("/register", userData);

      this.user = response.data;
    },
  },

  persist: true,
});
