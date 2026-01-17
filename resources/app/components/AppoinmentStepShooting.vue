<script setup lang="ts">
import type { CustomerProduct, Shooting } from "resources";

const props = defineProps<{
  shootings: object;
  customerProduct: CustomerProduct;
}>();
defineEmits(["saveShooting"]);
</script>

<template>
  <div class="step-shootings-container">
    <h3>Wähle dein Fotoshooting</h3>
    <div class="shootings">
      <div v-for="s in shootings" :key="s.product_id">
        <button @click="$emit('saveShooting', s)" class="shooting">{{ s.title }}</button>
      </div>
    </div>
  </div>
</template>

<style>
.step-shootings-container {
  h3 {
    @apply font-lato-bold py-8 font-bold md:pb-8;
  }
  .shootings {
    @apply grid-cols-shootings-grid grid gap-4 sm:gap-8;

    .shooting {
      @apply bg-blue hover:bg-brown text-creme font-lato-regular flex h-full w-full cursor-pointer flex-col items-center justify-center rounded-md p-8 text-base md:text-lg;
    }
  }
}
</style>
