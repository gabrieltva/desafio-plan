<script setup>
import HeaderLogin from '@/components/HeaderLogin.vue'
import Button from '@/components/Button.vue'
import Input from '@/components/Input.vue'
</script>

<template>
  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <header-login message="Cadastre-se" />

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" action="#" method="POST">
        <Input type="text" name="name" label="Nome" required="true" />
        <Input type="email" name="email" label="E-mail" required="true" />
        <Input type="password" name="password" label="Senha" required="true" />
        <Input type="password" name="repeat-password" label="Repetir senha" required="true" />

        <Button type="submit">
          Cadastrar
        </Button>

      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        Já tem conta?
        {{ ' ' }}
        <router-link to="/" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Faça o login</router-link>
      </p>
    </div>
  </div>
</template>