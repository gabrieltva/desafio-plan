<script setup>
import { userDashboardRouterName } from '@/utils/user';
import HeaderLink from './HeaderLink.vue';
import { userToken, removeUserData } from "@/utils/user";
import { useRouter } from 'vue-router';
import { userRole } from '../utils/user';
import { ref } from 'vue';

const router = useRouter();
const showMenuMobile = ref(false)

const logout = async () => {
  const response = await fetch(import.meta.env.VITE_API_URL_LOGOUT, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + userToken()
    }
  });
  if (response.ok) {
    removeUserData();
    router.push({ name: 'login' })
  }
}

const toggleMobileMenu = () => {
  showMenuMobile.value = !showMenuMobile.value
}

</script>

<template>
  <header class="fixed z-10 w-full shadow-lg">
    <nav class="bg-white/50 backdrop-blur-sm border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800/30 dark:backdrop-blur-sm">
      <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
        <router-link :to="{ name: userDashboardRouterName() }" class="flex items-center">
          <h1 class="text-indigo-300 text-center uppercase font-bold text-2xl">Desafio Plan</h1>
        </router-link>
        <div class="flex items-center lg:order-2">
          <button type="button" @click="logout"
            class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">
            Sair
          </button>
          <button type="button" @click="toggleMobileMenu"
            class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Open main menu</span>
            <span v-if="showMenuMobile === false">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                  clip-rule="evenodd"></path>
              </svg>
            </span>
            <span v-else>
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                  clip-rule="evenodd"></path>
              </svg>
            </span>
          </button>
        </div>
        <div :class="`${showMenuMobile === true ? 'block': 'hidden'} justify-between items-center w-full lg:flex lg:w-auto lg:order-1`" id="mobile-menu-2">
          <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
            <header-link :to="userDashboardRouterName()" :actived="true">Home</header-link>
            <header-link v-if="userRole() === 'admin'" to="adminStudentsList">Colaboradores</header-link>
            <header-link v-if="userRole() === 'admin'" to="adminCoursesList">Cursos</header-link>
            <header-link v-if="userRole() === 'student'" to="studentCoursesList">Cursos</header-link>
          </ul>
        </div>
      </div>
    </nav>
  </header>
</template>