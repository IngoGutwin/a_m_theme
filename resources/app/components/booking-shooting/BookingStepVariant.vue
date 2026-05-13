<script setup lang="ts">
import type { ShootingVariant } from "resources";
defineProps<{
  variants: Record<string, ShootingVariant> | null;
  variant: string;
}>();
defineEmits(["toggleVariant"]);
</script>

<template>
  <h3>Wähle deine Variante</h3>
  <div class="shooting-variants" data-testid="booking-step-variants">
    <div v-for="v in variants" :key="v.title">
      <button
        class="variant"
        :data-selected="variant === v.title"
        @click="$emit('toggleVariant', v)"
      >
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
    @apply text-creme font-lato-regular flex h-full w-full cursor-pointer flex-col items-center justify-center rounded-md bg-black p-4 text-base hover:bg-gray-700 md:text-lg;

    h4 {
      @apply font-lato-bold py-2 text-base font-bold md:text-xl;
    }

    p {
      @apply text-sm md:text-lg;
    }
  }

  .variant[data-selected="true"] {
    @apply bg-gray-500;
  }
}
</style>
