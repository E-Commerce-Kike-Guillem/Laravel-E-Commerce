<template>
  <div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Importar Productes (XLSX)</h2>
    <input type="file" @change="handleFileUpload" accept=".xlsx" />
    <button @click="submitImport" class="bg-green-600 text-white px-4 py-2 mt-4">
      Carregar Fitxer
    </button>
  </div>
</template>

<script setup>
import http from '../services/http';
import { ref } from 'vue';

const file = ref(null);

const handleFileUpload = (e) => { file.value = e.target.files[0]; };

const submitImport = async () => {
  try {
    // 1. Obtener la cookie CSRF
    await http.get('/sanctum/csrf-cookie'); 
    
    // 2. Hacer el POST
    const formData = new FormData();
    formData.append('file', file.value);
    
    await http.post('/products/import', formData);
    alert('Importat!');
  } catch (error) {
    console.error("Error:", error.response?.data);
  }
};
</script>