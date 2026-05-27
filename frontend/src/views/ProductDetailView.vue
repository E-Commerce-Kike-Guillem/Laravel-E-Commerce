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
        <h3>Deixa la teva opinió</h3>
        <form @submit.prevent="handleCommentSubmit">
          <div class="form-row">
            <label for="puntuacio">Valoració:</label>
            <select id="puntuacio" v-model="commentForm.rating" class="select-rating">
              <option value="5">★★★★★ (Excel·lent)</option>
              <option value="4">★★★★ (Molt bo)</option>
              <option value="3">★★★ (Correcte)</option>
              <option value="2">★★ (Regular)</option>
              <option value="1">★ (Dolent)</option>
            </select>
          </div>
          
          <div class="form-row">
            <label for="textComentari">Comentari:</label>
            <textarea id="textComentari" v-model="commentForm.text" class="input-comment" placeholder="Escriu aquí..." required></textarea>
          </div>
          
          <button type="submit" class="btn-submit-comment" :disabled="submittingComment">
            {{ submittingComment ? 'Publicant...' : 'Publicar' }}
          </button>
        </form>
      </div>
      
      <div v-else class="login-notice">
        <p><RouterLink to="/login">Inicia sessió</RouterLink> per a deixar un comentari.</p>
      </div>

      <div id="llista-comentaris" class="mt-4">
        <p v-if="loadingComments">Carregant comentaris...</p>
        <p v-else-if="comments.length === 0" style="color:#777; font-style:italic;">Sigues el primer a comentar!</p>
        
        <div v-else class="comment" v-for="c in comments" :key="c.id">
          <div class="comment-header" style="display:flex; justify-content:space-between;">
            <span>
              {{ c.user_name || 'Usuari' }} 
              <span style="color:#f39c12;">{{ '★'.repeat(c.rating || 5) + '☆'.repeat(5 - (c.rating || 5)) }}</span>
            </span>
            <div>
              <span class="comment-date">{{ formatDate(c.created_at) }}</span>
              
              <template v-if="canEditOrDelete(c.user_id)">
                <button @click="editComment(c)" style="color:blue; border:none; background:none; cursor:pointer; margin-left:10px;" title="Editar">
                  <i class="fas fa-pen"></i>
                </button>
                <button @click="deleteComment(c.id)" style="color:red; border:none; background:none; cursor:pointer; margin-left:5px;" title="Esborrar">
                  <i class="fas fa-trash"></i>
                </button>
              </template>
            </div>
          </div>
          <div class="comment-body">{{ c.text }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useAuthStore } from '../stores/authStore';
import http from '../services/http';

import { useComments } from '../composables/useComments'; 

const route = useRoute();
const authStore = useAuthStore();
const product = ref(null);
const loading = ref(true);

const commentForm = ref({ text: '', rating: 5 });

const { 
  comments, 
  loadingComments, 
  submittingComment, 
  loadComments, 
  submitComment, 
  deleteComment, 
  editComment, 
  canEditOrDelete, 
  formatDate 
} = useComments(route.params.id);

onMounted(async () => {
  try {
    const response = await http.get(`/products/${route.params.id}`);
    product.value = response.data.data || response.data;
    
    await loadComments();
  } catch (err) {
    console.error("Error:", err);
  } finally {
    loading.value = false;
  }
});

const handleCommentSubmit = async () => {
  const success = await submitComment(commentForm.value.text, commentForm.value.rating);
  if (success) {
    commentForm.value.text = '';
    commentForm.value.rating = 5;
  }
};
</script>

<style scoped>
@import '@/assets/css/stylesDetalle.css';
</style>