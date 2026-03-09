<script setup lang="ts">
import type { Participants } from "resources";
import { ParticipantsSchema } from "@lib/validation/schemas/participants.schema";
import { ref, reactive, watchEffect } from "vue";
import type { ZodIssueBase } from "zod";

defineEmits<{
  (e: "render-step", step: string): void;
}>();

const participants = defineModel<Participants>("participants", {
  required: true,
});

const nextStep = ref<boolean>(false);

const validationErrors = reactive<Partial<Record<keyof Participants, string[]>>>({});

const showErrors = (issues: ZodIssueBase[]) => {
  issues.forEach((issue) => {
    let field = issue.path[0];
    let message = issue.message;
    validationErrors[field] = [message];
  });
};

watchEffect(() => {
  let result = ParticipantsSchema.safeParse(participants.value);
  nextStep.value = result.success;
  if (!result.success) {
    showErrors(result.error.issues);
  } else {
    Object.keys(validationErrors).forEach((error) => {
      delete validationErrors[error];
    });
  }
});
</script>

<template>
  <div data-testid="booking-step-participants">
    <h3>Wer wird da sein?</h3>
    <div class="shooting-people">
      <div class="participants">
        <label for="adults">Erwachsene</label>
        <input
          id="adults"
          v-model="participants.adults"
          type="text"
          placeholder="min. 1 Erwachsener"
          name="adults"
          required="true"
        />
        <span v-if="validationErrors.adults" class="error">
          {{ validationErrors.adults[0] }}
        </span>
      </div>
      <div class="participants">
        <label for="childrens">Kinder ab 2 Jahren</label>
        <input
          id="childrens"
          v-model="participants.childrens"
          type="text"
          placeholder="0"
          name="childrens"
        />
        <span v-if="validationErrors.childrens" class="error">
          {{ validationErrors.childrens[0] }}
        </span>
      </div>
      <div class="participants">
        <label for="toddlers">Kinder bis 2 Jahren</label>
        <input
          id="toddlers"
          v-model="participants.toddlers"
          type="text"
          placeholder="0"
          name="toddlers"
        />
        <span v-if="validationErrors.toddlers" class="error">
          {{ validationErrors.toddlers[0] }}
        </span>
      </div>
      <div class="participants">
        <label for="animals">Haustiere</label>
        <input
          id="animals"
          v-model="participants.animals"
          type="text"
          placeholder="0"
          name="animals"
        />
        <span v-if="validationErrors.animals" class="error">
          {{ validationErrors.animals[0] }}
        </span>
      </div>
    </div>
    <div class="bottom-controls">
      <button :disabled="!nextStep" class="forward-btn" @click="$emit('render-step', 'variants')">
        weiter
      </button>
    </div>
  </div>
</template>

<style>
.shooting-people {
  @apply font-lato-bold flex flex-wrap gap-4 text-black;

  .participants {
    @apply relative flex flex-col gap-x-4;

    .error {
      @apply font-lato-regular absolute -bottom-6 text-red-500;
    }

    label {
      @apply py-2;
    }

    input {
      @apply rounded-md bg-gray-300 px-2 py-1;
    }
  }
}
</style>
