<script setup>
import { onMounted, reactive, ref } from 'vue';
import ListSkeleton from '@/components/ListSkeleton.vue';
import ListItem from '@/components/ListItem.vue';
import ListTable from '@/components/ListTable.vue';
import { getStatusContent } from '@/utils/course';
import { adminGetStudentCourse } from '@/services/api';

const props = defineProps({
  id: {
    type: Number,
    required: true,
  }
})

const isLoading = ref(false)

const dataStudent = reactive({
  name: '',
  email: '',
  courses: [],
  courses_student_reference: []
})

const emit = defineEmits(['click'])
const onClose = () => {
  emit('click')
}

onMounted(async () => {
  isLoading.value = true
  try {
    const data = await adminGetStudentCourse(props.id)
    dataStudent.name = data.name
    dataStudent.email = data.email
    dataStudent.courses = data.courses
    dataStudent.courses_student_reference = data.courses_student_reference
  } finally {
    isLoading.value = false
  }
})

const getStatus = (index) => {
  const status = dataStudent.courses_student_reference[index].status
  return getStatusContent(status)
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
            <span>Visualizar colaborador: {{ dataStudent.name }}</span>
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

        <!-- Modal body -->
        <div class="grid gap-4 mb-4 sm:grid-cols-2">
          <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
            <input type="text" name="name" id="name" disabled
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              :value="dataStudent.name">
          </div>
          <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">E-mail</label>
            <input type="text" name="email" id="email" disabled
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              :value="dataStudent.email">
          </div>

          <div v-if="dataStudent.courses.length > 0" class="sm:col-span-2">
            <fieldset>
              <label for="students" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Cursos
              </label>

              <ListTable :headerItems="['id', 'Title', 'Status']">

                <ListItem v-for="(c, index) in dataStudent.courses" :key="c.id" :id="c.id"
                  :items="[c.id, c.title, getStatus(index)]" />

                <p v-if="!isLoading && dataStudent.courses.length <= 0" class="p-6">Nenhum curso vinculado</p>

              </ListTable>
            </fieldset>
          </div>

          <ListSkeleton v-if="isLoading" />

        </div>
      </div>

    </div>
    <div class="h-full w-full bg-black/50 cursor-pointer z-9 absolute start-0 top-0" @click="onClose"></div>
  </div>
</template>