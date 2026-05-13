<script setup lang="ts">
import LabelElement from "@components/LabelElement.vue";
import type { ValidationErrors, TouchedFields } from "resources";
import type { Customer } from "@lib/validation/schemas/customer.schema";
import { customerFormFields } from "./booking.form.shape";

const customer = defineModel<Customer>("customer", {
  required: true,
});

const props = defineProps<{
  validationErrors: ValidationErrors<Customer>;
}>();

const emit = defineEmits<{
  (e: "touch-customer-field", field: keyof Customer): void;
}>();
</script>
<template>
  <div data-testid="booking-step-customer">
    <h3>Deine Daten</h3>
    <div class="input-container">
      <div
        v-for="field in customerFormFields"
        :key="field.id"
        class="data"
        :class="{ gdpr: field.id === 'gdpr' || field.id === 'newsletter' }"
      >
        <LabelElement :label="field.label" :link="field.link" :for="field.id" />
        <input
          :id="field.id"
          v-model="customer[field.id as keyof Customer]"
          :type="field.type"
          :name="field.id"
          :required="field.required"
          :data-testid="field.dataTestId"
          :autocomplete="field.autocomplete"
          @input.once="emit('touch-customer-field', field.id as keyof Customer)"
        />
        <span v-if="props.validationErrors[field.id as keyof Customer]" class="error">
          {{ props.validationErrors[field.id as keyof Customer] }}
        </span>
      </div>
    </div>
  </div>
</template>
<style>
.input-container {
  @apply font-lato-bold gap-4 text-black sm:flex sm:flex-wrap;

  .data {
    @apply relative flex max-w-48 flex-col items-start gap-x-4;

    label {
      @apply py-2;
    }

    input {
      @apply rounded-md bg-gray-300 px-2 py-1;
    }
  }
  .gdpr {
    @apply font-lato-regular my-8 flex max-w-fit flex-col flex-wrap items-start gap-4 text-base text-black;

    label {
      a {
        @apply text-base font-bold;
      }
    }

    input[type="checkbox"] {
      @apply h-4 w-4 rounded-md accent-black;
    }

    .error {
      @apply font-lato-regular bottom-0 text-red-500;
    }
  }

  .error {
    @apply font-lato-regular bottom-0 text-red-500;
  }
}
</style>
