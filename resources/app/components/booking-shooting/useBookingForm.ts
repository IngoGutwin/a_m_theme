import type {
  Shooting,
  ShootingVariant,
  Booking,
  ValidationErrors,
  TouchedFields,
} from "resources";
import type { Customer } from "@lib/validation/schemas/customer.schema";
import { ParticipantsSchema } from "@lib/validation/schemas/participants.schema";
import { CustomerSchema } from "@lib/validation/schemas/customer.schema";
import { FetchApi, type WpPost } from "@app/utils/fetch.api.wrapper.utils";
import { computed, type ComputedRef, onMounted, reactive, ref } from "vue";
import { type ZodSchema } from "zod";

export function useBookingForm() {
  const apiURL = import.meta.env.VITE_API_URL;
  const shootingLeadsApiURL = import.meta.env.VITE_SHOOTING_LEAD_POST_API_URL;
  const API = FetchApi();

  // --- Daten ---

  const customer = reactive<Customer>({
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

  const booking = reactive<Booking>({
    title: "",
    productId: "",
    variant: { title: "", benefits: "" },
    participants: { adults: 0, toddlers: 0, childrens: 0, animals: 0 },
  });

  const shootings = ref<Shooting[]>([]);
  const shootingVariants = ref<Record<string, ShootingVariant> | null>(null);

  // --- Field Error Validation ---

  function useValidation<T extends object>(schema: ZodSchema<T>, data: T) {
    const touchedFields = reactive<TouchedFields<T>>({});

    function touchField(field: keyof T) {
      touchedFields[field] = true;
    }

    function touchAll() {
      (Object.keys(data) as (keyof T)[]).forEach((key) => {
        touchedFields[key] = true;
      });
    }

    const errors = computed<ValidationErrors<T>>(() => {
      const result = schema.safeParse(data);
      if (result.success) return {};

      return result.error.issues.reduce((acc, issue) => {
        const field = issue.path[0] as keyof T;
        if (touchedFields[field]) {
          acc[field] = issue.message;
        }
        return acc;
      }, {} as ValidationErrors<T>);
    });

    const isValid = computed(() => schema.safeParse(data).success);

    return { errors, touchField, touchAll, isValid };
  }

  const {
    errors: participantErrors,
    touchField: participantsSetTouchedField,
    touchAll: touchAllParticipants,
    isValid: participantsValid,
  } = useValidation(ParticipantsSchema, booking.participants);

  const {
    errors: customerErrors,
    touchField: touchCustomerField,
    touchAll: touchAllCustomer,
    isValid: customerValid,
  } = useValidation(CustomerSchema, customer);

  // --- StepConfig ---

  interface StepConfig {
    id: string;
    nextIsReady: ComputedRef<boolean>;
    skip?: () => boolean;
  }

  const stepConfig: StepConfig[] = [
    {
      id: "shooting",
      nextIsReady: computed(() => !!booking.productId),
    },
    {
      id: "participants",
      nextIsReady: participantsValid,
    },
    {
      id: "variants",
      nextIsReady: computed(() => !!booking.variant.title),
      skip: () => shootingVariants.value === null,
    },
    {
      id: "customer",
      nextIsReady: computed(() => customerValid.value && customer.gdpr),
    },
    {
      id: "checkup",
      nextIsReady: computed(() => false),
    },
  ];

  // --- Navigation ---

  const currentIndex = ref(0);
  const activeSteps = computed(() => stepConfig.filter((step) => !step.skip?.()));
  const currentStep = computed(() => activeSteps.value[currentIndex.value]);
  const formStep = computed(() => currentStep.value.id);
  const canGoBack = computed(() => currentIndex.value > 0);
  const canGoNext = computed(() => currentStep.value.nextIsReady.value);

  function renderStep(direction: "next" | "back") {
    if (direction === "next" && canGoNext.value) {
      if (formStep.value === "participants") touchAllParticipants();
      if (formStep.value === "customer") touchAllCustomer();
      currentIndex.value++;
    } else if (direction === "back" && canGoBack.value) {
      currentIndex.value--;
    }
  }

  // --- Shooting ---

  function hasVariants(variants: Record<string, ShootingVariant>): boolean {
    return Object.values(variants).some((v) => !!v.title);
  }

  function toggleShooting({ title, product_id, variants }: Shooting) {
    if (booking.title === title) {
      booking.title = "";
      booking.productId = "";
      shootingVariants.value = null;
    } else {
      booking.title = title;
      booking.productId = product_id;
      shootingVariants.value = hasVariants(variants) ? variants : null;
    }
  }

  // --- Variants ---

  function toggleVariant({ title, benefits }: ShootingVariant) {
    const isSelected = booking.variant.title === title;
    booking.variant.title = isSelected ? "" : title;
    booking.variant.benefits = isSelected ? "" : benefits;
  }

  // --- Checkup ---
  async function sendQuery() {
    try {
      let response = await API.post({
        url: shootingLeadsApiURL,
        body: {
          ...customer,
          ...booking,
        },
      });
      console.log(response);
    } catch (e) {
      API.handleNetworkError(e);
    }
  }

  // --- API ---

  onMounted(async () => {
    try {
      let response = await API.get<WpPost<Shooting>[]>(`${apiURL}/shooting`);

      if (API.isWpError(response)) return;

      if (response) {
        shootings.value = response.map((raw: WpPost<Shooting>) => raw.acf);
      }
    } catch (e) {
      API.handleNetworkError(e);
    }
  });

  return {
    // Data
    customer,
    booking,
    shootings,
    shootingVariants,
    // Validation
    participantErrors,
    customerErrors,
    // Navigation
    formStep,
    canGoBack,
    canGoNext,
    // Actions
    renderStep,
    toggleShooting,
    toggleVariant,
    participantsSetTouchedField,
    touchCustomerField,
    sendQuery,
  };
}
