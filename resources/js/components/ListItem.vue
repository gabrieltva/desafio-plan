<script setup>

defineProps({
  id: Number,
  items: {
    type: Array,
    required: true,
    default: []
  },
  button: {
    type: String,
    required: true,
  },
  click: Function
})

const emit = defineEmits(['click'])

const handleClick = () => {
  emit('click')
}
</script>

<template>
  <tr :key="id" class="border-b dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
    
    <td v-for="item in items" class="px-4 py-3">{{ item }}</td>

    <td class="px-4 py-3 flex items-center justify-end">
      <button @click="handleClick"
        class="inline-flex items-center p-0.5 text-sm font-medium text-center text-green-500 hover:text-green-800 rounded-lg focus:outline-none dark:text-green-400 dark:hover:text-green-100"
        type="button">
        {{ button }}
      </button>
    </td>
  </tr>
</template>