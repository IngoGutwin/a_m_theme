<script setup lang="ts">
import type { Shooting } from "resources";
defineProps<{
  shootings: Shooting[];
}>();
defineEmits(["saveShooting"]);
</script>

<template>
  <div data-testid="booking-step-shootings">
    <h3>Wähle dein Fotoshooting</h3>
    <div class="shootings">
      <div v-for="s in shootings" :key="s.product_id">
        <button class="shooting" @click="$emit('saveShooting', s)">{{ s.title }}</button>
      </div>
    </div>
  </div>
</template>

<style>
.shootings {
  @apply grid-cols-shootings-grid grid gap-4 sm:gap-8;

  .shooting {
    @apply font-lato-bold text-creme flex h-full w-full cursor-pointer flex-col items-center justify-center rounded-md bg-black p-8 hover:bg-gray-700 md:text-lg;
  }
}
</style>
