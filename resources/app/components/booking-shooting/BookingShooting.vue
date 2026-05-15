<script setup lang="ts">
import BookingStepShooting from "./BookingStepShooting.vue";
import BookingStepParticipants from "./BookingStepParticipants.vue";
import BookingStepVariant from "./BookingStepVariant.vue";
import BookingStepCustomer from "./BookingStepCustomer.vue";
import BookingStepCheckUp from "./BookingStepCheckUp.vue";
import ControlsButton from "./ControlsButton.vue";
import { useBookingForm } from "./useBookingForm";

const {
  formStep,
  shootings,
  booking,
  customer,
  canGoBack,
  canGoNext,
  participantErrors,
  shootingVariants,
  customerErrors,
  toggleShooting,
  renderStep,
  toggleVariant,
  participantsSetTouchedField,
  touchCustomerField,
  sendQuery,
} = useBookingForm();
</script>

<template>
  <div class="booking-shooting-form">
    <BookingStepShooting
      v-if="formStep === 'shooting'"
      :shootings="shootings"
      :booking-title="booking.title"
      @toggle-shooting="toggleShooting"
    />

    <BookingStepParticipants
      v-if="formStep === 'participants'"
      v-model:participants="booking.participants"
      :validation-errors="participantErrors"
      @participants-set-touched-field="participantsSetTouchedField"
    />

    <BookingStepVariant
      v-if="formStep === 'variants'"
      :variants="shootingVariants"
      :variant="booking.variant.title"
      @toggle-variant="toggleVariant"
    />

    <BookingStepCustomer
      v-if="formStep === 'customer'"
      v-model:customer="customer"
      :validation-errors="customerErrors"
      @touch-customer-field="touchCustomerField"
    />

    <BookingStepCheckUp v-if="formStep === 'checkup'" :customer="customer" :booking="booking" />
  </div>

  <div class="booking-shooting-controls-wrapper">
    <div class="booking-shooting-controls">
      <ControlsButton text="zurück" :disabled="!canGoBack" @click="renderStep('back')" />
      <ControlsButton
        v-if="formStep === 'checkup'"
        text="Absenden"
        data-testid="send-query-button"
        @click="sendQuery"
      />
      <ControlsButton
        v-else-if="formStep !== 'checkup'"
        text="weiter"
        :disabled="!canGoNext"
        data-testid="go-next-button"
        @click="renderStep('next')"
      />
    </div>
  </div>
</template>

<style>
.booking-shooting-section {
  @apply grid-rows-view-ui grid max-w-5xl gap-4 p-2 sm:gap-8 xl:p-0;

  .booking-shooting-form {
    @apply row-span-1 row-start-1 pb-48 md:p-0;

    h3 {
      @apply font-lato-bold py-8 font-bold md:pb-8;
    }
    h4 {
      @apply font-lato-regular py-8 font-normal md:pb-8;
    }
  }
}
.booking-shooting-controls-wrapper {
  @apply fixed bottom-0 left-0 z-50 w-full;

  .booking-shooting-controls {
    @apply bg-creme mx-auto flex max-w-5xl justify-between px-2 xl:p-0;
  }
}
</style>
