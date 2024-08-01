<script setup>
import Footer from '@/components/Footer.vue'
import Header from '@/components/Header.vue'
import user from '@/utils/user';
</script>

<template>
  <Header />
  <main class="bg-gray-50 dark:bg-gray-900 px-3 sm:px-5 flex-1 min-h-full pt-24">
    <h1 class="text-center text-indigo-600 dark:text-indigo-200 text-3xl">Bem-vindo, {{ user()?.name }}</h1>
  </main>
  <Footer />
</template>