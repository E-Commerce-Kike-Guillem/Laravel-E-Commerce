<template>
  <div class="detail-wrapper container my-5">
    
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status"></div>
    </div>

    <div v-else-if="product" class="product-detail-card">
      <div class="detail-image">
        <img :src="product.image || '/contenido/image.png'" alt="Imatge del producte">
      </div>
      
      <div class="detail-info">
        <h1 class="detail-title">{{ product.name }}</h1>
        
        <div class="like-container">
          <button id="btnLike" class="btn-like" @click="toggleLike">
            <i :class="[isLiked ? 'fas' : 'far', 'fa-heart']"></i>
          </button>
          <span><span id="likeCount">{{ likeCount }}</span> persones els agrada</span>
        </div>

        <p class="detail-sku">REF: {{ product.sku || 'GENERIC' }}</p>
        <div class="detail-price">{{ product.price }} €</div>
        <div class="detail-desc">
          <p>{{ product.description }}</p>
        </div>
        <p>Estoc disponible: <strong>{{ product.stock }}</strong></p>
        
        <button class="btn-add-cart" @click="addToCart">Afegir al Carret</button>
      </div>
    </div>

    <div class="comments-section" v-if="product">
      <h2>Comentaris</h2>
      <div v-if="authStore.isAuthenticated" class="comment-form-container">
        </div>
      <div v-else class="login-notice">
        <p><RouterLink to="/login">Inicia sessió</RouterLink> per a deixar un comentari.</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useAuthStore } from '../stores/authStore';
import http from '../services/http';

const route = useRoute();
const authStore = useAuthStore();
const product = ref(null);
const loading = ref(true);
const isLiked = ref(false);
const likeCount = ref(0);

onMounted(async () => {
  const { id } = route.params;
  try {
    const response = await http.get(`/products/${id}`);
    product.value = response.data.data || response.data;
    // Aquí podries fer una segona crida per carregar likes i comentaris:
    // const likes = await http.get(`/products/${id}/likes`);
  } catch (err) {
    console.error("Error:", err);
  } finally {
    loading.value = false;
  }
});

const toggleLike = () => { isLiked.value = !isLiked.value; likeCount.value += isLiked.value ? 1 : -1; };
const addToCart = () => { alert('Producte afegit!'); };
</script>

<style scoped>
@import '@/assets/css/stylesDetalle.css';
</style>