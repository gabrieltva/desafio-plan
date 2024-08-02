<script setup>
import { onMounted, ref } from 'vue';
import Footer from '@/components/Footer.vue'
import Header from '@/components/Header.vue'
import { userToken } from "@/utils/user";
import ListContainer from '@/components/ListContainer.vue';
import ListItem from '@/components/ListItem.vue';
import Show from '@/pages/admin/students/Show.vue';

const content = ref([])
const isLoading = ref(false)
const showModal = ref(false)
const idUserModal = ref('')

onMounted(async () => {
  isLoading.value = true
  try {
    const response = await fetch(import.meta.env.VITE_API_URL_STUDENTS, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + userToken()
      }
    });
    const data = await response.json()
    if (response.ok) {
      content.value = data
    } else {

    }
  } catch (error) {

  } finally {
    isLoading.value = false
  }
})

const toggleModal = (id = '') => {
  showModal.value = !showModal.value
  idUserModal.value = id
}
</script>

<template>
  <Header />
  <main class="bg-white flex-1 flex flex-col min-h-screen">
    <ListContainer :headerItems="['id', 'Nome', 'E-mail']" :isLoading="isLoading.value">

      <ListItem v-for="c in content" :id="c.id" :items="[c.id, c.name, c.email]" button="Visualizar" @click="toggleModal(c.id)" />

      <p v-if="!isLoading.value && content.length <= 0" class="p-6">Nenhum registro encontrado</p>

    </ListContainer>

    <Show v-if="showModal" :id="idUserModal" @click="toggleModal"  />
    <Footer />
  </main>
</template>