<script setup lang="ts">
const props = defineProps({
  variants: Object,
});
defineEmits(["saveVariant"]);
</script>

<template>
  <h3>Wähle deine Variante</h3>
  <div class="shooting-variants">
    <div v-for="v in variants">
      <button @click="$emit('saveVariant', v)" class="variant">
        <h4>{{ v.title }}</h4>
        <p>{{ v.benefits }}</p>
      </button>
    </div>
  </div>
</template>

<style>
h3 {
  @apply font-lato-bold py-8 font-bold md:pb-8;
}
.shooting-variants {
  @apply flex flex-wrap gap-4;

  .variant {
    @apply bg-blue hover:bg-brown text-creme font-lato-regular flex h-full w-full cursor-pointer flex-col items-center justify-center rounded-md p-4 text-base md:text-lg;

    h4 {
      @apply font-lato-bold py-2 text-base font-bold md:text-xl;
    }

    p {
      @apply text-sm md:text-lg;
    }
  }
}
</style>
