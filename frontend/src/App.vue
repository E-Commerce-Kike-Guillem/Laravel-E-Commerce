<script setup>
import Navbar from './components/Navbar.vue';
import { RouterView } from 'vue-router';
</script>

<template>
  <header>
    <Navbar></Navbar>
  </header>

  <main>
    <RouterView></RouterView>
  </main>
</template>