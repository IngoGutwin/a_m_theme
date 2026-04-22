import type { Shooting, ShootingVariant, Booking, Participants } from "resources";
import type { Customer } from "@lib/validation/schemas/customer.schema";
import { computed, onMounted, reactive, ref, watchEffect, type Ref } from "vue";
import { FetchApi } from "@app/utils/fetch.api.wrapper.utils";
import type { core } from "zod";

export function useBookingForm() {
  let API = FetchApi();
  let apiURL = import.meta.env.VITE_API_URL;

  let shootings = ref<[]>([]);
  let shootingVariants = ref<Record<string, ShootingVariant> | null>({});

  let customer = reactive<Customer>({
    firstName: "",
    lastName: "",
    city: "",
    email: "",
    street: "",
    houseNumber: "",
    zipCode: "",
    mobilePhone: "",
    gdpr: false,
    newsLetter: false,
  });

  let booking = reactive<Booking>({
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

  interface StepConfig {
    id: string;
    nextIsReady: Ref<boolean, boolean>;
  }

  let stepConfig: StepConfig[] = [
    {
      id: "shooting",
      nextIsReady: ref(false),
    },
    {
      id: "participants",
      nextIsReady: ref(false),
    },
  ];

  let currentIndex = ref(0);
  let formStep = computed(() => stepConfig[currentIndex.value].id);
  let canGoBack = computed(() => (currentIndex.value > 0 ? true : false));
  let canGoNext = computed(() => stepConfig[currentIndex.value].nextIsReady.value);

  let updateNextStepReady = () =>
    (stepConfig[currentIndex.value].nextIsReady.value = stepConfig[currentIndex.value].nextIsReady
      .value
      ? false
      : true);

  function renderStep(direction: string) {
    console.log(direction);
  }

  function toggleShooting(shooting: Shooting) {
    let { title, product_id } = shooting;
    function saveShooting() {
      booking.title = title;
      booking.productId = product_id;
      if (!canGoNext.value) {
        updateNextStepReady();
      }
    }
    function clearShooting() {
      booking.title = "";
      booking.productId = "";
      if (canGoNext.value) {
        updateNextStepReady();
      }
    }
    if (booking.title === title) {
      clearShooting();
    } else {
      saveShooting();
    }
  }

  onMounted(async () => {
    /**
     * get data from API
     */
    let response = await API.get(`${apiURL}/shooting`);
    shootings.value = response.map((rawShooting) => {
      let shooting: Shooting = rawShooting.acf;
      return shooting;
    });
  });

  return {
    // data
    customer,
    booking,
    shootingVariants,
    shootings,
    stepConfig,
    formStep,
    canGoBack,
    canGoNext,
    // functions
    toggleShooting,
    renderStep,
  };
}
