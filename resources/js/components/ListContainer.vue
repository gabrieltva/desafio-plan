<script setup>
import ListSkeleton from './ListSkeleton.vue';
import ListTable from './ListTable.vue';

defineProps({
  headerItems: {
    type: Array,
    required: true,
    default: []
  },
  showButton: {
    type: Boolean,
    default: false
  },
  nameButton: String,
  isLoading: Boolean,
})

const emit = defineEmits(['click']);

const onClick = () => {
  emit('click');
}

</script>

<template>

  <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 flex-1 min-h-full">
    <div class="mx-auto max-w-screen-xl px-4 pt-16 lg:px-12">
      <!-- Start coding here -->
      <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">

        <div v-if="showButton"
          class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0 p-4">
          <button type="button" @click="onClick"
            class="flex items-center justify-center text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
            {{ nameButton }}
          </button>
        </div>

        <ListTable :headerItems="headerItems">
          <slot />
        </ListTable>

        <ListSkeleton v-if="isLoading" />

      </div>
    </div>
  </section>
</template>