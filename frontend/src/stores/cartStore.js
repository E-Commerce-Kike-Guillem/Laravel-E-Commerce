// frontend/src/stores/cartStore.js
import { defineStore } from "pinia";
import http from "../services/http";
import { useAuthStore } from "./authStore"; // 1. IMPORTA AQUÍ

export const useCartStore = defineStore("cart", {
  state: () => ({
    items: [],
  }),
  getters: {
    totalItems: (state) => state.items.reduce((acc, item) => acc + item.quantity, 0),
    totalPrice: (state) => state.items.reduce((acc, item) => acc + (item.product.price * item.quantity), 0),
  },
  actions: {
    clearCart() { this.items = []; },
    
    async fetchCart() {
      const response = await http.get("/cart");
      this.items = response.data;
    },

    async addToCart(product) {
      const authStore = useAuthStore(); // 2. USA EL HOOK CORRECTAMENTE
      
      if (authStore.isAuthenticated) {
        await http.post("/cart", { product_id: product.id, quantity: 1 });
      }

      const existing = this.items.find((i) => i.product.id === product.id);
      if (existing) existing.quantity++;
      else this.items.push({ product, quantity: 1 });
    },

    async removeFromCart(productId) {
      const authStore = useAuthStore(); // 3. IMPORTANTE: Definir authStore aquí también

      if (authStore.isAuthenticated) {
        await http.delete(`/cart/${productId}`);
      }

      this.items = this.items.filter(item => item.product.id !== productId);
    },
  },
  persist: true,
});