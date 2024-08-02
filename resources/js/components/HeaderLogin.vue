<script setup>
const props = defineProps({
  message: {
    type: String,
    required: true,
  }
})
</script>

<template>
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <h1 class="text-indigo-600 text-center uppercase font-bold text-5xl">Desafio Plan</h1>
    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900 dark:text-gray-400">{{ message }}</h2>
  </div>
</template>