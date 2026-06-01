import { defineStore } from "pinia";
import http from "../services/http";
import { useCartStore } from "./cartStore"; // 1. IMPORTACIÓN AÑADIDA

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: null,
  }),

  getters: {
    // Al ser getters, se calculan SOLOS cuando "state.user" cambia.
    // Nunca debes hacer "this.isAuthenticated = true" manualmente.
    isLoggedIn: (state) => !!state.user,
    isAuthenticated: (state) => !!state.user,
  },

  actions: {
    async login(credentials) {
      await http.get("/sanctum/csrf-cookie");

      const response = await http.post("/login", credentials);
      
      // Con solo guardar el usuario, isAuthenticated pasa a true automáticamente
      this.user = response.data; 

      const cartStore = useCartStore(); // Ahora sí funcionará porque está importado
      await cartStore.fetchCart();
    },

    async logout() {
      await http.post("/logout");
      
      // Al poner el usuario a null, isAuthenticated pasa a false automáticamente
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
      // Corregido para usar la ruta relativa igual que en el login
      await http.get("/sanctum/csrf-cookie");

      const response = await http.post("/register", userData);

      this.user = response.data;
    },
  },

  persist: true,
});