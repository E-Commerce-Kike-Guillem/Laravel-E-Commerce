import { defineStore } from "pinia";
import http from "../services/http";
import { useCartStore } from "./cartStore"; 

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: null,
  }),

  getters: {
    isLoggedIn: (state) => !!state.user,
    isAuthenticated: (state) => !!state.user,
  },

  actions: {
    async login(credentials) {
      await http.get("/sanctum/csrf-cookie");

      const response = await http.post("/login", credentials);
      
      this.user = response.data; 

      const cartStore = useCartStore(); 
      await cartStore.fetchCart();
    },

    async logout() {
      await http.post("/logout");
      
      this.user = null;

      const cartStore = useCartStore();
      cartStore.clearCart();
    },

    async fetchUser() {
      try {
        const response = await http.get("/user");
        this.user = response.data;
      } catch (error) {
        this.user = null;
      }
    },

    async register(userData) {
      await http.get("/sanctum/csrf-cookie");

      const response = await http.post("/register", userData);

      this.user = response.data;
    },
  },

  persist: true,
});