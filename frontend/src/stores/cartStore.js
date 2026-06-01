import { defineStore } from "pinia";
import http from "../services/http";
import { useAuthStore } from "./authStore"; 

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
      const authStore = useAuthStore(); 
      
      if (authStore.isAuthenticated) {
        await http.post("/cart", { product_id: product.id, quantity: 1 });
      }

      const existing = this.items.find((i) => i.product.id === product.id);
      if (existing) existing.quantity++;
      else this.items.push({ product, quantity: 1 });
    },

    async removeFromCart(productId) {
      const authStore = useAuthStore(); 

      if (authStore.isAuthenticated) {
        await http.delete(`/cart/${productId}`);
      }

      this.items = this.items.filter(item => item.product.id !== productId);
    },
    async checkoutOrder() {
      try {
        const response = await http.post("/checkout");
        this.clearCart();
        return { success: true, order: response.data.order };
      } catch (error) {
        console.error("Error al tramitar la comanda:", error);
        return { success: false, message: error.response?.data?.error || "Error desconegut" };
      }
    },
  },
  persist: true,
});