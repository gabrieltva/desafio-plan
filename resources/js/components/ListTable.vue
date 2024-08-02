<script setup>
defineProps({
  headerItems: {
    type: Array,
    required: true,
    default: []
  }
})
</script>

<template>
  <div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th v-for="item in headerItems" scope="col" class="px-4 py-3">{{ item }}</th>
          <th scope="col" class="px-4 py-3">
            <span class="sr-only">Actions</span>
          </th>
        </tr>
      </thead>
      <tbody>

        <slot />

      </tbody>
    </table>
  </div>
</template>