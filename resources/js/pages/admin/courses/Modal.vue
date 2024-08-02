<script setup>
import { onMounted, reactive, ref } from 'vue';
import Alert from '@/components/Alert.vue';
import { userToken } from "@/utils/user";
import ListSkeleton from '@/components/ListSkeleton.vue';

const props = defineProps({
  id: Number,
  title: String,
  description: String,
  students: Array
})

const isRegistering = ref(false)
const isRemoving = ref(false)
const isLoading = ref(false)
const studentsContent = ref([])

const alertMessage = ref('')
const alertType = ref('error')

const formData = reactive({
  titleInput: ref(props.title),
  descriptionInput: ref(props.description),
  studentsInput: ref(props.students.map(item => item.id))
})

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
      studentsContent.value = data
    } else {

    }
  } catch (error) {

  } finally {
    isLoading.value = false
  }
})

const onSubmit = async (event) => {
  isRegistering.value = true;
  alertMessage.value = '';

  const method = props.id ? 'PUT' : 'POST'
  const url = props.id ? import.meta.env.VITE_API_URL_COURSE_UPDATE.replace(':id', props.id) : import.meta.env.VITE_API_URL_COURSE_REGISTER
  const dataSend = {
    title: formData.titleInput,
    description: formData.descriptionInput,
    students: formData.studentsInput,
    id: props.id
  }

  try {
    const response = await fetch(url, {
      method: method,
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + userToken()
      },
      body: JSON.stringify(dataSend)
    });
    const data = await response.json();
    if (response.ok) {
      
      if (!props.id) {
        resetForm()
        showToast('Curso cadastrado com sucesso', 'success')
      }
      else {
        showToast('Curso atualizado com sucesso', 'success')
      }
    } else {
      showToast(data.message);
    }
  } catch (error) {
    showToast(error);
    console.error('Erro na requisição:', error);
  } finally {
    isRegistering.value = false;
  }
}

const onRemove = async (event) => {
  isRemoving.value = true
  const url = import.meta.env.VITE_API_URL_COURSE_DELETE.replace(':id', props.id);

  try {
    const response = await fetch(url, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + userToken()
      }
    });
    if (response.ok) {
      onClose()
    } else {
      const data = await response.json()
      showToast(data.message);
    }
  } catch (error) {
    showToast(error);
  } finally {
    isRemoving.value = false
  }
}

const showToast = (message, type = 'error') => {
  alertMessage.value = message;
  alertType.value = type;
}

const emit = defineEmits(['click'])
const onClose = () => {
  emit('click')
}

const resetForm = () => {
  formData.titleInput = ''
  formData.descriptionInput = ''
  formData.studentsInput = []
}

</script>

<template>
  <div tabindex="-1" aria-hidden="true"
    class="fixed overflow-y-auto overflow-x-hidden top-0 right-0 left-0 z-50 items-center w-full md:inset-0 h-modal md:h-full flex align-cente justify-center">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto z-10">
      <!-- Modal content -->
      <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
        <!-- Modal header -->
        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            <span v-if="id">Atualizar curso</span>
            <span v-else>Cadastrar curso</span>
          </h3>
          <button type="button" @click="onClose"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-toggle="updateProductModal">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Fechar modal</span>
          </button>
        </div>

        <alert v-if="alertMessage !== ''" v-model="alertMessage" :type="alertType" />

        <!-- Modal body -->
        <form @submit.prevent="onSubmit">
          <div class="grid gap-4 mb-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
              <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Título</label>
              <input type="text" name="title" id="title"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                placeholder="" v-model="formData.titleInput">
            </div>
            <div class="sm:col-span-2">
              <label for="description"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descrição</label>
              <textarea id="description" rows="5"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                placeholder="Escreva uma descrição..." v-model="formData.descriptionInput"></textarea>
            </div>
            <div class="sm:col-span-2">
              <fieldset>
                <label for="students" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vincular
                  estudantes</label>

                <ListSkeleton v-if="isLoading" />
                
                <div v-else v-for="s in studentsContent" :key="s.id" class="flex items-center mb-4">
                  <input :id="`student-${s.id}`" type="checkbox" :value="s.id" v-model="formData.studentsInput"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                  <label :for="`student-${s.id}`" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    {{ s.name }}
                  </label>
                </div>
              </fieldset>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <button type="submit" :disabled="isRegistering"
              class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
              <span v-if="isRegistering">Carregando...</span>
              <span v-else-if="id">Atualizar curso</span>
              <span v-else>Cadastrar curso</span>
            </button>

            <button v-if="id" type="button" :disabled="isRemoving" @click="onRemove"
              class="text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
              <svg class="mr-1 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                  clip-rule="evenodd"></path>
              </svg>
              <span v-if="isRemoving">Carregando...</span>
              <span v-else>Remover</span>
            </button>
          </div>
        </form>
      </div>

    </div>
    <div class="h-full w-full bg-black/50 cursor-pointer z-9 absolute start-0 top-0" @click="onClose"></div>
  </div>
</template>