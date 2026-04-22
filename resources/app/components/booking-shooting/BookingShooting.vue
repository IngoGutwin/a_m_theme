<script setup lang="ts">
import BookingStepCustomer from "./BookingStepCustomer.vue";
import BookingStepShooting from "./BookingStepShooting.vue";
import BookingStepVariant from "./BookingStepVariant.vue";
import BookingStepParticipants from "./BookingStepParticipants.vue";
import BookingStepCheckUp from "./BookingStepCheckUp.vue";
import { useBookingForm } from "./useBookingForm";
import ControlsButton from "./ControlsButton.vue";

const { booking, shootings, formStep, canGoBack, canGoNext, toggleShooting, renderStep } =
  useBookingForm();
</script>

<template>
  <div class="booking-shooting-form">
    <BookingStepShooting
      v-if="formStep === 'shooting'"
      :shootings="shootings"
      :booking-title="booking.title"
      @toggle-shooting="toggleShooting"
    />
  </div>
  <div class="booking-shooting-controls">
    <ControlsButton text="zurück" :disabled="!canGoBack" @click="renderStep('back')" />
    <ControlsButton text="weiter" :disabled="!canGoNext" @click="renderStep('next')" />
  </div>
</template>

<style>
.booking-shooting-section {
  .booking-shooting-form {
    @apply my-8;
    h3 {
      @apply font-lato-bold py-8 font-bold md:pb-8;
    }
    h4 {
      @apply font-lato-regular py-8 font-normal md:pb-8;
    }
  }

  .booking-shooting-controls {
    @apply bg-creme fixed bottom-0 left-0 flex w-full justify-between px-2 md:static;
  }
}
</style>
