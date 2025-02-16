<script setup lang="ts">
defineProps<{
  id?: string;
  label: string;
  placeholder?: string;
  type?: string;
  name?: string;
}>();

const model = defineModel();
</script>

<template>
  <div class="w-full">
    <label :for="id" class="block text-sm font-medium text-gray-700">{{
      label
    }}</label>
    <input
      v-model="model"
      :type="type"
      :id="id"
      :name="name"
      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
    />
  </div>
</template>
