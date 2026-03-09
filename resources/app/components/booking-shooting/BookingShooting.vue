<script setup lang="ts">
import type { Shooting, ShootingVariant } from "resources";
import { onMounted, reactive, ref } from "vue";
import { FetchApi } from "@app/utils/fetch.api.wrapper.utils";
import BookingStepCustomer from "./BookingStepCustomer.vue";
import BookingStepShooting from "./BookingStepShooting.vue";
import BookingStepVariant from "./BookingStepVariant.vue";
import BookingStepParticipants from "./BookingStepParticipants.vue";

const stepOrder = ["shooting", "participants", "variants", "customer"];
type FormStep = (typeof stepOrder)[number];
const formStep = ref<FormStep>(stepOrder[0]);

const API = FetchApi();

// container for API data
const shootings = ref<[]>([]);

// shooting variant which is set on the first step
let shootingVariants = ref<Record<string, ShootingVariant>>({});

const booking = reactive({
  title: "",
  productId: "",
  variant: {
    title: "",
    benefits: "",
  },
  participants: {
    adults: 0,
    toddlers: 0,
    childrens: 0,
    animals: 0,
  },
});
const customer = ref({
  firstName: "",
  lastName: "",
  email: "",
  street: "",
  city: "",
  zipCode: 0,
  houseNm: "",
  gdpr: false,
});

const saveShooting = (shooting: Shooting) => {
  let { title, product_id, variants } = shooting;
  shootingVariants.value = variants;
  booking.title = title;
  booking.productId = product_id;
  renderStep(stepOrder[1]);
};

const saveVariant = (variant: ShootingVariant) => {
  booking.variant = variant;
  renderStep(stepOrder[3]);
};

const renderStep = (step: string) => {
  formStep.value = step;
};

const goBack = () => {
  let currentStep = stepOrder.indexOf(formStep.value);
  let nextStep = stepOrder[currentStep - 1];
  renderStep(nextStep);
};

// hooks

onMounted(async () => {
  const response = await API.get("http://a-m.test/wp-json/wp/v2/shooting");
  shootings.value = response.map((shooting) => {
    return shooting.acf;
  });
});
</script>

<template>
  <div class="shooting-appoinments-container">
    <div class="top-controls">
      <button class="back-btn" :disabled="formStep === 'shooting'" @click="goBack()">zurück</button>
    </div>
    <BookingStepShooting
      v-if="formStep === stepOrder[0]"
      :shootings="shootings"
      data-testid="booking-step-shootings"
      @save-shooting="saveShooting"
    />
    <BookingStepParticipants
      v-if="formStep === stepOrder[1]"
      v-model:participants="booking.participants"
      data-testid="booking-step-participants"
      @render-step="renderStep"
    />
    <BookingStepVariant
      v-if="formStep === stepOrder[2]"
      :variants="shootingVariants"
      data-testid="booking-step-variants"
      @save-variant="saveVariant"
    />
    <BookingStepCustomer
      v-if="formStep === stepOrder[3]"
      v-model:customer="customer"
      @render-step="renderStep"
    />
  </div>
</template>

<style>
.shooting-appoinments-container {
  @apply min-h-[50vh] sm:py-4;

  .top-controls {
    .back-btn {
      @apply font-lato-bold text-creme cursor-pointer rounded-md bg-black px-4 py-2 text-base hover:bg-gray-700;
    }
    .back-btn:disabled {
      @apply cursor-not-allowed opacity-50;
    }
  }

  h3 {
    @apply font-lato-bold py-8 font-bold md:pb-8;
  }

  .bottom-controls {
    .forward-btn {
      @apply font-lato-bold text-creme my-8 cursor-pointer rounded-md bg-black px-4 py-2 text-base hover:bg-gray-700 md:my-12;
    }
    .forward-btn:disabled {
      @apply cursor-not-allowed opacity-50;
    }
  }
}
</style>
