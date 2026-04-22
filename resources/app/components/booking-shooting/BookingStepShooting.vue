<script setup lang="ts">
import type { Shooting } from "resources";
defineProps<{
  shootings: Shooting[];
  bookingTitle: string;
}>();
defineEmits<{
  (e: "toggle-shooting", shooting: Shooting): void;
}>();
</script>

<template>
  <div data-testid="booking-step-shootings" class="shootings-container">
    <h3>Welches Fotoshooting interessiert dich?</h3>
    <div class="shootings">
      <button
        v-for="s in shootings"
        :key="s.product_id"
        :data-selected="bookingTitle === s.title"
        class="shooting"
        @click="$emit('toggle-shooting', s)"
      >
        {{ s.title }}
      </button>
    </div>
  </div>
</template>

<style>
.shootings-container {
  .shootings {
    @apply grid-cols-shootings-grid grid gap-4 sm:gap-8;

    .shooting {
      @apply font-lato-bold text-creme flex h-full w-full cursor-pointer flex-col items-center justify-center rounded-md bg-black p-8 hover:bg-gray-700 md:text-lg;
    }

    .shooting[data-selected="true"] {
      @apply bg-gray-500;
    }
  }
}
</style>
