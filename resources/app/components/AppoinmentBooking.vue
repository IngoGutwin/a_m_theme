<script setup lang="ts">
import type { Customer, CustomerAppoinment, CustomerProduct, Shooting } from "resources";
import { onMounted, reactive, ref } from "vue";
import { FetchApi } from "../utils/fetch.api.wrapper.utils";
import AppoinmentStepShooting from "./AppoinmentStepShooting.vue";
import AppoinmentStepVariant from "./AppoinmentStepVariant.vue";

// variables

const API = FetchApi();
const shootings = ref<[]>([]);
let shootingVariants = {};

const formStep = ref<number>(1);
const customerProduct = reactive<CustomerProduct>({
  title: "",
  productId: "",
  variant: {},
});
const customerData = reactive<Customer>({
  firstName: "",
  lastName: "",
  gdpr: false,
});

// functions

const goBack = () => {
  if (formStep.value === 3) {
    formStep.value = 2;
    return;
  } else if (formStep.value === 2) {
    formStep.value = 1;
    return;
  } else {
    return window.history.back();
  }
};

const saveShooting = (shooting: Shooting) => {
  let { title, product_id, variants } = shooting;
  customerProduct.title = title;
  customerProduct.productId = product_id;
  shootingVariants = variants;
  renderForm(2);
};

const saveVariant = (variant: object) => {
  customerProduct.variant = variant;
};

const renderForm = (step: number) => {
  formStep.value = step;
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
    <div class="top-ctl">
      <button @click="goBack()" class="back-btn">zurück</button>
    </div>
    <AppoinmentStepShooting
      @save-shooting="saveShooting"
      :shootings="shootings"
      :customerProduct="customerProduct"
      v-if="formStep === 1"
    />
    <AppoinmentStepVariant
      @save-variant="saveVariant"
      :variants="shootingVariants"
      v-if="formStep === 2"
    />
  </div>
</template>

<style>
.shooting-appoinments-container {
  @apply min-h-[50vh] sm:py-4;

  .top-ctl {
    .back-btn {
      @apply border-blue bg-brown font-lato-regular text-creme hover:bg-blue cursor-pointer self-end rounded-md border-4 px-2 text-base;
    }
  }
}
</style>
