<template>
  <section class="hero w-full h-[500px] relative overflow-hidden">
    <div 
      class="hero-content w-full h-full bg-cover bg-center flex flex-col justify-center items-center text-white p-4"
      :style="{ backgroundImage: `url(${heroImage})` }"
    >
      <div class="bg-black/40 p-8 rounded-lg text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">Descobreix Peces Úniques</h1>
        <p class="text-xl mb-6">La nostra nova col·lecció inspirada en la cultura popular.</p>
        
        <button @click="goToShop" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">
          Explora la Col·lecció
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { useRouter } from 'vue-router'
import heroImage from '@/assets/contenido/hero_mod.jpg'

const router = useRouter()

const goToShop = () => {
  router.push('/products') 
}
</script>