<script setup lang="ts">
import type { Participants } from "resources";

const participants = defineModel<Participants>("participants", { required: true });

type ValidationErrors<T> = Partial<Record<keyof T, string>>;

const props = defineProps<{
  validationErrors: ValidationErrors<Participants>;
}>();

const emit = defineEmits<{
  (e: "participants-set-touched-field", field: keyof Participants): void;
}>();
</script>

<template>
  <div data-testid="booking-step-participants" class="participants-container">
    <h3>Wer wird da sein?</h3>
    <div class="participants-fields">
      <div class="participants-field">
        <label for="adults">Erwachsene</label>
        <input
          id="adults"
          v-model="participants.adults"
          type="text"
          placeholder="min. 1 Erwachsener"
          name="adults"
          required="true"
          @input.once="emit('participants-set-touched-field', 'adults')"
        />
        <span v-if="props.validationErrors.adults" class="error">
          {{ props.validationErrors.adults }}
        </span>
      </div>
      <div class="participants-field">
        <label for="childrens">Kinder ab 2 Jahren</label>
        <input
          id="childrens"
          v-model="participants.childrens"
          type="text"
          placeholder="0"
          name="childrens"
          @input.once="emit('participants-set-touched-field', 'childrens')"
        />
        <span v-if="props.validationErrors.childrens" class="error">
          {{ props.validationErrors.childrens }}
        </span>
      </div>
      <div class="participants-field">
        <label for="toddlers">Kinder bis 2 Jahren</label>
        <input
          id="toddlers"
          v-model="participants.toddlers"
          type="text"
          placeholder="0"
          name="toddlers"
          @input.once="emit('participants-set-touched-field', 'toddlers')"
        />
        <span v-if="props.validationErrors.toddlers" class="error">
          {{ props.validationErrors.toddlers }}
        </span>
      </div>
      <div class="participants-field">
        <label for="animals">Haustiere</label>
        <input
          id="animals"
          v-model="participants.animals"
          type="text"
          placeholder="0"
          name="animals"
          @input.once="emit('participants-set-touched-field', 'animals')"
        />
        <span v-if="props.validationErrors.animals" class="error">
          {{ props.validationErrors.animals }}
        </span>
      </div>
    </div>
  </div>
</template>

<style>
.participants-container {
  h3 {
    @apply font-lato-bold py-8 font-bold md:pb-8;
  }
  .participants-fields {
    @apply font-lato-bold flex flex-wrap gap-4 text-black;

    .participants-field {
      @apply relative flex flex-col gap-x-4;

      .error {
        @apply font-lato-regular -bottom-6 text-red-500;
      }

      label {
        @apply py-2;
      }

      input {
        @apply rounded-md bg-gray-300 px-2 py-1;
      }
    }
  }
}
</style>
