<script setup>
import HeaderLogin from '@/components/HeaderLogin.vue'
import Button from '@/components/Button.vue'
import Input from '@/components/Input.vue'
import Alert from '@/components/Alert.vue';
import { onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { setUser, userDashboardRouterName } from '@/utils/user'

const isLoading = ref(false)
const adminList = ref([])
const errorMessage = ref('')
const router = useRouter();

const dataForm = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  role: 'admin',
  admin_id: null
})

onMounted(async () => {
  isLoading.value = true
  try {
    const response = await fetch(import.meta.env.VITE_API_URL_ADMINS, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      }
    });
    const data = await response.json()
    if (response.ok) {
      adminList.value = data
    }
  } finally {
    isLoading.value = false
  }
})

const onSubmit = async () => {
  isLoading.value = true;
  errorMessage.value = '';
  try {
    const dataPost = {
      name: dataForm.name,
      email: dataForm.email,
      password: dataForm.password,
      password_confirmation: dataForm.password_confirmation,
      role: dataForm.role,
    }

    if (dataForm.role === 'admin') {
      dataPost['admin_id'] = dataForm.admin_id
    }

    const response = await fetch(import.meta.env.VITE_API_URL_REGISTER, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(dataPost)
    });
    const data = await response.json();
    if (response.ok) {
      setUser(data.token, data.user)

      router.push({ name: userDashboardRouterName() });
    } else {
      showToast(data.message);
    }
  } catch (error) {
    showToast(error);
    console.error('Erro na requisição:', error);
  } finally {
    isLoading.value = false;
  }
};

const showToast = (message) => {
  errorMessage.value = message;
}

</script>

<template>
  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <header-login message="Cadastre-se" />

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm p-4 rounded-md shadow-lg bg-white dark:bg-gray-800">
      <alert v-if="errorMessage !== ''" v-model="errorMessage" />

      <form class="space-y-6" @submit.prevent="onSubmit">
        <Input type="text" name="name" label="Nome" required="true" v-model="dataForm.name" />
        <Input type="email" name="email" label="E-mail" required="true" v-model="dataForm.email" />
        <Input type="password" name="password" label="Senha" required="true" v-model="dataForm.password" />
        <Input type="password" name="password_confirmation" label="Repetir senha" required="true"
          v-model="dataForm.password_confirmation" />

        <div class="space-y-2">
          <label for="role" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-200">Cargo</label>
          <select name="role" v-model="dataForm.role"
            class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            <option selected value="admin">Gestor</option>
            <option value="student">Outro</option>
          </select>
        </div>

        <div v-if="dataForm.role === 'student'" class="space-y-2">
          <label for="admin_id" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-200">Seu
            gestor</label>
          <select name="admin_id" v-model="dataForm.admin_id"
            class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            <option v-for="admin in adminList" :value="admin.id">{{ admin.name }}</option>
          </select>
        </div>

        <Button type="submit" :loading="isLoading">
          Cadastrar
        </Button>

      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        Já tem conta?
        {{ ' ' }}
        <router-link to="/" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Faça o
          login</router-link>
      </p>
    </div>
  </div>
</template>