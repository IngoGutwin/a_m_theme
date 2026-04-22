<script setup lang="ts">
const props = defineProps<{
  text: string;
  disabled?: boolean;
  onClick: () => void;
}>();
</script>

<template>
  <button :disabled="props.disabled" class="forward-btn" @click="onClick">
    {{ text }}
  </button>
</template>

<style>
.forward-btn {
  @apply font-lato-bold text-creme my-8 cursor-pointer rounded-md bg-black px-4 py-2 text-base hover:bg-gray-700 md:my-12;
}
.forward-btn:disabled {
  @apply cursor-not-allowed opacity-50;
}
</style>
