<script setup>
import { onMounted, ref } from 'vue';
import Footer from '@/components/Footer.vue'
import Header from '@/components/Header.vue'
import { userToken } from "@/utils/user";
import ListContainer from '@/components/ListContainer.vue';
import ListItem from '@/components/ListItem.vue';
import { getStatusContent } from '@/utils/course';
import { getNextStatus } from '../../../utils/course';

const content = ref([])
const isLoading = ref(false)

onMounted(() => {
  getData()
})

const getData = async () => {
  isLoading.value = true
  try {
    const response = await fetch(import.meta.env.VITE_API_URL_STUDENT_COURSE_PAGE, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + userToken()
      }
    });
    const data = await response.json()
    if (response.ok) {
      content.value = data
    }
  } finally {
    isLoading.value = false
  }
}

const onClickButton = async (id, status) => {
  if (isLoading.value) {
    return
  }

  const nextStatus = getNextStatus(status)

  isLoading.value = true
  try {
    const response = await fetch(import.meta.env.VITE_API_URL_STUDENT_COURSE_STATUS.replace(':id', id), {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + userToken()
      },
      body: JSON.stringify({
        status: nextStatus
      })
    });
    if (response.ok) {
      getData()
    }
  } finally {
    isLoading.value = false
  }
}
</script>

<template>
  <Header />
  <main class="bg-white flex-1 flex flex-col min-h-screen">
    <ListContainer :headerItems="['id', 'Título', 'Descrição', 'Status']" :isLoading="isLoading">

      <ListItem 
        v-for="c in content" :id="c.course.id"
        :items="[c.course.id, c.course.title, c.course.description, (isLoading.value ? 'Carregando...' : getStatusContent(c.status))]"
        button="Mudar status"
        @click="onClickButton(c.id, c.status)" />

      <p v-if="!isLoading.value && content.length <= 0" class="p-6">Nenhum registro encontrado</p>

    </ListContainer>
    <Footer />
  </main>
</template>