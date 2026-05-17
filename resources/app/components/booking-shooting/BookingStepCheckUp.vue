<script setup lang="ts">
import type { Booking } from "resources";
import type { Customer } from "@lib/validation/schemas/customer.schema";
import { computed } from "vue";
import { customerFormFields, participantsFormFields } from "./booking.form.shape";

const props = defineProps<{
  customer: Customer;
  booking: Booking;
}>();

const customerData = computed(() => {
  const skip: (keyof Customer)[] = ["gdpr", "newsLetter", "honeyPot"];
  return Object.fromEntries(
    Object.entries(props.customer).filter(([key]) => !skip.includes(key as keyof Customer))
  ) as Omit<Customer, "gdpr" | "newsLetter">;
});

const participantData = computed(() =>
  Object.entries(props.booking.participants).filter(([, val]) => Number(val) > 0)
);
</script>

<template>
  <div data-testid="booking-step-checkup">
    <h3>Überprüfe nochmal deine Angaben!</h3>
    <h4>Wenn alles stimmt, klicke unten auf Absenden!</h4>

    <!-- Shooting -->
    <div class="checkup-section">
      <h4>Fotoshooting</h4>
      <p>{{ booking.title }}</p>
    </div>

    <!-- Variants -->
    <div v-if="booking.variant.title" class="checkup-section">
      <h4>Variante</h4>
      <p>{{ booking.variant.title }}</p>
      <p v-if="booking.variant.benefits">
        {{ booking.variant.benefits }}
      </p>
    </div>

    <!-- Participants -->
    <div class="checkup-section">
      <h4>Teilnehmer</h4>
      <table class="checkup-table">
        <tr v-for="[key, val] in participantData" :key="key">
          <th scope="row">
            {{ participantsFormFields[key as keyof typeof participantsFormFields].label }}:
          </th>
          <td>{{ val }}</td>
        </tr>
      </table>
    </div>

    <!-- Customer -->
    <div class="checkup-section">
      <h4>Deine Daten</h4>
      <table class="checkup-table">
        <tr v-for="(val, key) in customerData" :key="key">
          <th scope="row">
            {{ customerFormFields[key as keyof typeof customerFormFields].label }}:
          </th>
          <td>{{ val }}</td>
        </tr>
      </table>
    </div>
  </div>
</template>

<style>
.checkup-section {
  h4 {
    @apply font-lato-bold font-bold md:text-xl;
  }

  p {
    @apply font-lato-regular py-2 text-lg;
  }
}

.checkup-table {
  @apply font-lato-regular text-lg md:text-xl;

  th {
    @apply font-lato-bold pr-4 text-left;
  }
}
</style>
