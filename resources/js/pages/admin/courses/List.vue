<script setup>
import { onMounted, ref } from 'vue';
import Footer from '@/components/Footer.vue'
import Header from '@/components/Header.vue'
import { userToken } from "@/utils/user";
import ListContainer from '@/components/ListContainer.vue';
import ListItem from '@/components/ListItem.vue';

const content = ref([])
const isLoading = ref(false)

onMounted(async () => {
  isLoading.value = true
  try {
    const response = await fetch(import.meta.env.VITE_API_URL_COURSES, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + userToken()
      }
    });
    const data = await response.json();
    if (response.ok) {
      content.value = data
    } else {

    }
  } catch (error) {

  } finally {
    isLoading.value = false
  }
})
</script>

<template>
  <Header />
  <main class="bg-white flex-1 flex flex-col min-h-screen">
    <ListContainer :headerItems="['id', 'Title', 'Description']" :isLoading="isLoading.value">

      <ListItem v-for="c in content" :id="c.id" :items="[c.id, c.title, c.description]" button="Editar" />

      <p v-if="!isLoading.value && content.length <= 0" class="p-6">Nenhum registro encontrado</p>

    </ListContainer>
    <Footer />
  </main>
</template>