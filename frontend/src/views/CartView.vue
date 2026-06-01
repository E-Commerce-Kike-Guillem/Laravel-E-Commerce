<template>
  <div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">El teu Carret</h2>
    
    <div v-if="cartStore.items.length === 0">El carret és buit.</div>
    
    <div v-else>
      <div v-for="item in cartStore.items" :key="item.product.id" class="flex justify-between border-b py-4">
        <span>{{ item.product.name }} - {{ item.quantity }} x {{ item.product.price }}€</span>
        <button @click="cartStore.removeFromCart(item.product.id)" class="text-red-500">Eliminar</button>
      </div>
      <div class="mt-4 font-bold text-xl">Total: {{ cartStore.totalPrice }}€</div>
      <button class="bg-[#243020] text-white !px-5 !py-3 !my-10 !rounded-lg transition-transform duration-300 ease-in-out transform hover:scale-110 text-xl font-semibold">Tramitar Comanda</button>
    </div>
  </div>
</template>

<script setup>
import { useCartStore } from '../stores/cartStore';
const cartStore = useCartStore();
</script>