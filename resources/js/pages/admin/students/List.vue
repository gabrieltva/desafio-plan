<script setup>
import { onMounted, ref } from 'vue';
import Footer from '@/components/Footer.vue'
import Header from '@/components/Header.vue'
import ListContainer from '@/components/ListContainer.vue';
import ListItem from '@/components/ListItem.vue';
import Show from '@/pages/admin/students/Show.vue';
import { adminGetStudentsList } from '@/services/api';

const content = ref([])
const isLoading = ref(false)
const showModal = ref(false)
const idUserModal = ref('')

onMounted(async () => {
  isLoading.value = true
  try {
    const data = await adminGetStudentsList()
    content.value = data
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