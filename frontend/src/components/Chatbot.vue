<template>
  <div id="n8n-chat"></div>
  <link href="https://cdn.jsdelivr.net/npm/@n8n/chat/dist/style.css" rel="stylesheet" />
</template>

<script setup>
import { onMounted } from 'vue';

onMounted(() => {
  if (!document.getElementById('n8n-chat-script')) {
    const script = document.createElement('script');
    script.id = 'n8n-chat-script';
    script.type = 'module';
    
    script.innerHTML = `
      import { createChat } from 'https://cdn.jsdelivr.net/npm/@n8n/chat/dist/chat.bundle.es.js';
      
      createChat({
        webhookUrl: "http://localhost:5678/webhook/964ce5bf-4a9f-4dd5-896b-092cfee43eca/chat", // ¡Acuérdate de volver a ponerla!
        target: "#n8n-chat", // Le decimos explícitamente que se ancle a nuestro div
        mode: "window",
        initialMessages: [
          "¡Hola! Sóc l'assistent de Per L'Art. Puc ajudar-te a buscar alguna joia?"
        ],
        i18n: {
          en: {
            title: "Assistent Per L'Art",
            subtitle: "Pregunta'm sobre els nostres productes",
            footer: "Desenvolupat amb ❤️",
            getStarted: "Nova conversa",
            inputPlaceholder: "Escriu el teu missatge...",
          },
        },
        styles: {
          colors: {
            // El color principal teñirá el círculo del botón y la cabecera
            brand: "#243020",
            brandTint: "#35452f",
            chatBackground: "#ffffff",
            messageBackground: "#fcfcfc",
            messageBackgroundBot: "#243020",
            messageTextBot: "#ffffff",
          }
        }
      });
    `;
    document.body.appendChild(script);
  }
});
</script>

<style>
/* --- 1. EL BOTÓN FLOTANTE (Color verde y borde blanco) --- */
.chat-window-toggle {
    right: 20px !important; /* Margen a la derecha */
    left: auto !important; 
    bottom: 30px !important; 
    
    background: none !important;
    background-image: none !important;
    background-color: #243020 !important; /* Tu verde */
    
    border: 3px solid white !important; /* Borde tipo WhatsApp */
    border-radius: 50% !important; 
    width: 60px !important;
    height: 60px !important;
}

/* Icono blanco interior */
.chat-window-toggle svg {
    fill: white !important;
    color: white !important;
    background: transparent !important;
}

/* --- 2. LA VENTANA DE CHAT (Tu solución de estructura + Posición) --- */
.chat-window {
    right: 20px !important;  /* Alineado con el botón */
    bottom: 100px !important; /* Encima del botón */
    
    flex-direction: column !important;
    border-radius: 16px !important; /* Aumenta este número si lo quieres más redondo (ej: 20px) */
    overflow: hidden !important; /* Evita que la cabecera cuadrada se asome por las esquinas */
}

.chat-window > .chat-layout {
    height: 100% !important;
    margin: 0 !important;
    padding: 0 !important;

    flex-direction: column !important;
    justify-content: flex-start !important;
}

/* Cabecera */
.chat-header {
    margin: 0 !important;
    flex-shrink: 0 !important;
    background-color: #243020 !important; /* Forzamos el verde de tu marca */
}

/* Mensajes */
.chat-body {
    flex: 1 1 auto !important;
    min-height: 0 !important;
}

/* Input */
.chat-footer {
    flex-shrink: 0 !important;
}
</style>