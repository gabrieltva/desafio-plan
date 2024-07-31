<script setup>
const props = defineProps({
  type: {
    type: String,
    default: 'submit'
  },
  loading: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['click']);

function handleClick() {
  emit('click');
}
</script>

<template>
  <button :type="props.type" @click="handleClick"
    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
    :disabled="props.loading">
    <span v-if="props.loading">Carregando...</span>
    <span v-else>
      <slot />
    </span>
  </button>
</template>