<script setup>
import { onMounted, ref } from 'vue';
import Footer from '@/components/Footer.vue'
import Header from '@/components/Header.vue'
import { userToken } from "@/utils/user";
import ListContainer from '@/components/ListContainer.vue';
import ListItem from '@/components/ListItem.vue';
import Modal from '@/pages/admin/courses/Modal.vue';

const content = ref([])
const isLoading = ref(false)
const showModal = ref(false)

onMounted(() => {
  getData()
})

const getData = async (event) => {
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
}

const toggleModal = () => {
  showModal.value = !showModal.value;

  if (!showModal.value) {
    getData()
  }
}
</script>

<template>
  <Header />
  <main class="bg-white flex-1 flex flex-col min-h-screen">
    <ListContainer :headerItems="['id', 'Title', 'Description']" :isLoading="isLoading.value" :showButton="true" nameButton="Cadastrar curso" @click="toggleModal">

      <ListItem v-for="c in content" :id="c.id" :items="[c.id, c.title, c.description]" button="Editar" @click="toggleModal" />

      <p v-if="!isLoading && content.length <= 0" class="p-6">Nenhum registro encontrado</p>

    </ListContainer>
    <Footer />

    <Modal v-if="showModal" @click="toggleModal" />
  </main>
</template>