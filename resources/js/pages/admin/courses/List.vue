<script setup>
import { onMounted, ref } from 'vue';
import Footer from '@/components/Footer.vue'
import Header from '@/components/Header.vue'
import { userToken } from "@/utils/user";
import ListContainer from '@/components/ListContainer.vue';
import ListItem from '@/components/ListItem.vue';

const content = ref([])

onMounted(async () => {
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

  }
})
</script>

<template>
  <Header />
  <main class="bg-white flex-1">

    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 min-h-dvh">
      <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
        <!-- Start coding here -->
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">

          <ListContainer :headerItems="['id', 'Title', 'Description']">

            <ListItem v-for="c in content" :id="c.id" :items="[c.id, c.title, c.description]" />

          </ListContainer>

        </div>
      </div>
    </section>

  </main>
  <Footer />
</template>