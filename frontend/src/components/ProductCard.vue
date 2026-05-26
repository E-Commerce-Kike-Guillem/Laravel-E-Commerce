<template>
  <div class="border rounded-lg shadow-md overflow-hidden bg-white flex flex-col">
    <div class="bg-gray-300 h-48 w-full flex items-center justify-center">
      <span class="text-gray-500">Imagen del producto</span>
    </div>
    
    <div class="p-4 flex-grow flex flex-col justify-between">
      <div>
        <h3 class="text-lg font-semibold mb-2">{{ product.name }}</h3>
        <p class="text-gray-600 text-sm mb-4">{{ product.description?.substring(0, 50) }}...</p>
      </div>
      
      <div class="flex items-center justify-between mt-4">
        <span class="text-xl font-bold text-green-600">{{ product.price }} €</span>
      </div>

      <div class="mt-4 flex gap-2">
        <button 
          @click="verDetalles" 
          class="flex-1 bg-blue-500 text-white py-1 rounded hover:bg-blue-600 transition text-sm"
        >
          Detalles
        </button>
        <button 
          @click="editarProducto" 
          class="flex-1 bg-yellow-500 text-white py-1 rounded hover:bg-yellow-600 transition text-sm"
        >
          Editar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const props = defineProps({
  product: {
    type: Object,
    required: true
  }
})

const router = useRouter()

const verDetalles = () => {
  router.push({ name: 'ProductShow', params: { id: props.product.id } })
}

const editarProducto = () => {
  router.push({ name: 'ProductEdit', params: { id: props.product.id } })
}
</script>