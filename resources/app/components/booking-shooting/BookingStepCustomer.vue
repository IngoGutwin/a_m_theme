<script setup lang="ts">
import { Customer } from "resources";
import { ref, reactive } from "vue";

defineEmits<{
  (e: "render-step", step: string): void;
}>();

const validationErrors = reactive<Partial<Record<keyof Customer, string[]>>>({});

const customer = defineModel<Customer>("customer", {
  required: true,
});

const nextStep = ref<boolean>(false);
</script>
<template>
  <div data-testid="booking-step-customer">
    <h3>Deine Daten</h3>
    <div class="customer">
      <div class="data">
        <label for="firstname">Vorname</label>
        <input
          id="firstname"
          v-model="customer.firstName"
          type="text"
          name="firstname"
          required="true"
        />
        <span v-if="validationErrors.firstname" class="error">
          {{ validationErrors.firstname[0] }}
        </span>
      </div>
      <div class="data">
        <label for="lastname">Nachname</label>
        <input
          id="lastname"
          v-model="customer.lastName"
          type="text"
          name="lastname"
          required="true"
        />
        <span v-if="validationErrors.lastname" class="error">
          {{ validationErrors.lastname[0] }}
        </span>
      </div>
      <div class="data">
        <label for="email">E-Mail</label>
        <input id="email" v-model="customer.email" type="text" name="email" required="true" />
        <span v-if="validationErrors.email" class="error">
          {{ validationErrors.email[0] }}
        </span>
      </div>
      <div class="data">
        <label for="telMobile">Tel Nr.</label>
        <input
          id="telMobile"
          v-model="customer.telMobile"
          type="text"
          name="telMobile"
          required="true"
        />
        <span v-if="validationErrors.telMobile" class="error">
          {{ validationErrors.telMobile[0] }}
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
.customer {
  @apply font-lato-bold flex flex-wrap gap-4 text-black;

  .data {
    @apply relative flex flex-col gap-x-4;

    .error {
      @apply font-lato-regular absolute bottom-0 text-red-500;
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
