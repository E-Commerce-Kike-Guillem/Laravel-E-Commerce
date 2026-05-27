<template>
  <section class="w-screen h-[500px] relative overflow-hidden">
    <!-- Usamos 'pl-20' (Padding Left) para forzar el espacio a la izquierda -->
    <div
      class="w-full h-full bg-cover bg-center flex flex-col justify-center text-white !pl-20"
      :style="{
        backgroundImage: `url(${heroImage})`,
        backgroundColor: 'transparent',
      }"
    >
      <!-- Un div que limita el ancho del texto para que no se pegue al otro lado -->
      <div class="max-w-xl text-left">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">
          Descobreix Peces Úniques
        </h1>
        <p class="text-xl mb-6">
          La nostra nova col·lecció inspirada en la cultura popular.
        </p>

        <button
          @click="goToShop"
          class="bg-[#243020] text-white !px-5 !py-3 !my-10 !rounded-lg transition-transform duration-300 ease-in-out transform hover:scale-110 text-xl font-semibold"
        >
          Explora la Col·lecció
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { useRouter } from "vue-router";
import heroImage from "../../public/contenido/hero_mod.jpg";

const router = useRouter();

const goToShop = () => {
  router.push("/products");
};
</script>

<style scoped>
.hero-full {
  width: 100vw; /* Fuerza el ancho de toda la ventana */
  height: 50vh; /* Ajusta la altura a tu gusto */
  background-image: url("../../public/contenido/hero_mod.jpg");
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0;
  padding: 0;
  /* Eliminamos cualquier color de fondo gris */
  background-color: transparent;
}

.hero-content {
  /* Eliminamos el fondo oscuro y el padding */
  background: none;
  padding: 0;
  text-align: center;
  color: white; /* Asegúrate de que el texto contraste con la imagen */
}
</style>
