<template>
  <main class="main-content">
    <section class="hero" :style="{ backgroundImage: `url(${heroImage})` }">
            <div class="hero-content">
                <h1>Descobreix Peces Úniques</h1>
                <p>La nostra nova col·lecció inspirada en la cultura popular.</p>
                <a class="btn btn-primary">Explora la Col·lecció</a>
            </div>
            <div class="hero-background-image"></div>
        </section>
  </main>
</template>

<script setup>
import heroImage from '@/assets/contenido/hero_mod.jpg'
import { useRouter } from 'vue-router'

const router = useRouter()

const goToShop = () => {
  router.push('/products') 
}
</script>