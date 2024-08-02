<script setup>

const props = defineProps({
  id: String,
  label: String,
  type: {
    type: String,
    default: 'text'
  },
  required: {
    type: String,
    default: 'false'
  },
  modelValue: String
});

const emit = defineEmits(['update:modelValue']);

const onInput = (event) => {
  emit('update:modelValue', event.target.value);
};

</script>

<template>
  <div>
    <label :for="props.name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-200">{{ props.label }}</label>
    <div class="mt-2">
      <input 
        :id="props.name"
        :name="props.name"
        :type="props.type"
        :required="props.required"
        :value="modelValue"
        @input="onInput"
        class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
    </div>
  </div>
</template>