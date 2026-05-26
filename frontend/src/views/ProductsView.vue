<template>
  <div class="products-container">
    <h2>Llistat de Productes</h2>

    <div v-if="loading">Connectant amb Laravel... ⏳</div>

    <div v-else-if="error" class="error">
      ❌ {{ error }}
    </div>

    <ul v-else>
      <li v-for="product in products" :key="product.id">
        <strong>{{ product.name }}</strong> - {{ product.price }} €
        <br>
        <small>{{ product.description }}</small>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

// Variables reactivas
const products = ref([]);
const loading = ref(true);
const error = ref(null);

// Cuando el componente se monta en la pantalla, llamamos a la API
onMounted(async () => {
  try {
    // Hacemos la petición GET a Laravel
    const response = await axios.get('http://localhost/api/products', {
      withCredentials: true // Muy importante para CORS y futuras sesiones
    });
    
    // Como Laravel envía paginación y un Resource, los datos están dentro de response.data.data
    products.value = response.data.data;
  } catch (e) {
    // Si la conexión falla, capturamos el error
    error.value = "No s'ha pogut connectar amb l'API de Laravel. Revisa la consola (F12).";
    console.error("Detalle del error:", e);
  } finally {
    // Pase lo que pase, quitamos el mensaje de carga
    loading.value = false;
  }
});
</script>

<style scoped>
.products-container {
  padding: 2rem;
}
.error {
  color: red;
  font-weight: bold;
}
li {
  margin-bottom: 1rem;
  list-style-type: none;
  padding: 1rem;
  border: 1px solid #ddd;
  border-radius: 8px;
}
</style>