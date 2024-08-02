<script setup>
import { ref } from 'vue'
import HeaderLogin from '@/components/HeaderLogin.vue'
import Button from '@/components/Button.vue'
import Input from '@/components/Input.vue'
import Alert from '@/components/Alert.vue';
import { useRouter } from 'vue-router';
import { userDashboardRouterName } from '@/utils/user';

const email = ref('')
const password = ref('')
const role = ref('admin')
const loading = ref(false)
const errorMessage = ref('')
const router = useRouter();

const onSubmit = async () => {
  loading.value = true;
  errorMessage.value = '';
  try {
    const response = await fetch(import.meta.env.VITE_API_URL_LOGIN, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        email: email.value,
        password: password.value,
        role: role.value
      })
    });
    const data = await response.json();
    if (response.ok) {
      localStorage.setItem('token', data.token);
      localStorage.setItem('user', JSON.stringify(data.user));

      router.push({ name: userDashboardRouterName() });
    } else {
      showToast(data.message);
    }
  } catch (error) {
    showToast(error);
    console.error('Erro na requisição:', error);
  } finally {
    loading.value = false;
  }
};

const showToast = (message) => {
  errorMessage.value = message;
}

</script>

<template>
  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <header-login message="Faça o login com sua conta" />

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <alert v-if="errorMessage !== ''" v-model="errorMessage" />

      <form class="space-y-6" @submit.prevent="onSubmit">
        <Input type="email" name="email" label="E-mail" required="true" v-model="email" />
        <Input type="password" name="password" label="Senha" required="true" v-model="password" />

        <div class="space-y-2">
          <label for="role" class="block text-sm font-medium leading-6 text-gray-900">Cargo</label>
          <select name="role" v-model="role"
            class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            <option value="admin">Gestor</option>
            <option value="student">Outro</option>
          </select>
        </div>


        <Button type="submit" :loading="loading">
          Login
        </Button>

      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        Não tem conta?
        {{ ' ' }}
        <router-link to="/register" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Registre-se
        </router-link>
      </p>
    </div>
  </div>
</template>