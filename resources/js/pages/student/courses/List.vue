<script setup>
import { onMounted, ref } from 'vue';
import Footer from '@/components/Footer.vue'
import Header from '@/components/Header.vue'
import ListContainer from '@/components/ListContainer.vue';
import ListItem from '@/components/ListItem.vue';
import { getStatusContent, getNextStatus } from '@/utils/course';
import { studentGetCourseList, studentChangeStatus } from '@/services/api';

const content = ref([])
const isLoading = ref(false)

onMounted(() => {
  getData()
})

const getData = async () => {
  isLoading.value = true
  try {
    const data = await studentGetCourseList()
    content.value = data
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
    studentChangeStatus(id, nextStatus)
    getData()
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