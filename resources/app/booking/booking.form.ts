import { FetchApi, type WpPost } from "@app/utils/fetch.api.wrapper.utils";
import {
  BookingFormSchema,
  type BookingData,
} from "@lib/validation/schemas/booking.schema";
import type { Customer } from "@lib/validation/schemas/customer.schema";

export interface Shooting {
  title: string;
  product_id: string;
}

type FormStatus = "idle" | "submitting" | "success" | "error";
type ErrorMap = Record<string, string>;

function emptyCustomer(): Customer {
  return {
    firstName: "",
    lastName: "",
    email: "",
    mobilePhone: "",
    message: "",
    gdpr: false,
    newsLetter: false,
    honeyPot: "",
  };
}

function emptyBooking(): BookingData {
  return {
    title: "",
    productId: "",
    participants: {
      adults: 0,
      toddlers: 0,
      childrens: 0,
      animals: 0,
    },
  };
}

function issuesToErrorMap(issues: { path: PropertyKey[]; message: string }[]): ErrorMap {
  const errors: ErrorMap = {};
  for (const issue of issues) {
    console.log(issue);
    const key = issue.path.map(String).join(".");
    if (key && !errors[key]) {
      errors[key] = issue.message;
    }
  }
  return errors;
}

export function bookingForm() {
  const apiURL = import.meta.env.VITE_API_URL;
  const shootingLeadsApiURL = import.meta.env.VITE_SHOOTING_LEAD_API_URL;
  const API = FetchApi();

  return {
    shootings: [] as Shooting[],
    customer: emptyCustomer(),
    booking: emptyBooking(),
    errors: {} as ErrorMap,
    status: "idle" as FormStatus,
    submitError: "",
    loadingShootings: true,
    redirectNotice: false,

    get isSubmitting(): boolean {
      return this.status === "submitting";
    },

    get isSuccess(): boolean {
      return this.status === "success";
    },

    async init() {
      await this.loadShootings();
    },

    async loadShootings() {
      this.loadingShootings = true;
      try {
        const response = await API.get<WpPost<Shooting>[]>(`${apiURL}/shooting`);
        if (API.isWpError(response) || !response) {
          this.submitError = "Shootings konnten nicht geladen werden.";
          return;
        }
        this.shootings = response.map((raw) => ({
          title: raw.acf.title,
          product_id: raw.acf.product_id,
        }));
      } catch (e) {
        API.handleNetworkError(e);
        this.submitError = "Shootings konnten nicht geladen werden.";
      } finally {
        this.loadingShootings = false;
      }
    },

    onShootingChange() {
      const selected = this.shootings.find((s) => s.product_id === this.booking.productId);
      this.booking.title = selected?.title ?? "";
      delete this.errors["booking.title"];
      delete this.errors["booking.productId"];
    },

    error(path: string) {
      return this.errors[path];
    },

    validate() {
      const result = BookingFormSchema.safeParse({
        customer: this.customer,
        booking: this.booking,
      });

      if (result.success) {
        this.errors = {};
        this.customer = result.data.customer;
        this.booking = result.data.booking;
        return true;
      }

      this.errors = issuesToErrorMap(result.error.issues);
      return false;
    },

    async submit(event: Event) {
      event.preventDefault();
      this.submitError = "";

      if (!this.validate()) {
        console.log(this.errors);
        this.status = "error";
        const firstKey = Object.keys(this.errors)[0];
        if (firstKey) {
          document
            .querySelector<HTMLElement>(`[data-error-for="${firstKey}"]`)
            ?.scrollIntoView({ behavior: "smooth", block: "center" });
        }
        return;
      }

      this.status = "submitting";

      try {
        console.log(this.customer);
        console.log(this.booking);
        const response = await API.post<
          { success?: boolean },
          { customer: Customer; booking: BookingData }
        >({
          url: shootingLeadsApiURL,
          body: {
            customer: { ...this.customer },
            booking: {
              ...this.booking,
              participants: { ...this.booking.participants },
            },
          },
        });

        if (API.isWpError(response) || !response) {
          this.status = "error";
          this.submitError = API.isWpError(response)
            ? response.message || "Senden fehlgeschlagen."
            : "Senden fehlgeschlagen. Bitte später erneut versuchen.";
          return;
        }

        if (response.success) {
          this.status = "success";
          //this.startRedirect();
          return;
        }

        this.status = "error";
        this.submitError = "Senden fehlgeschlagen. Bitte später erneut versuchen.";
      } catch (e) {
        API.handleNetworkError(e);
        this.status = "error";
        this.submitError = "Netzwerkfehler. Bitte später erneut versuchen.";
      }
    },

    // startRedirect() {
    //   window.setTimeout(() => {
    //     this.redirectNotice = true;
    //   }, 2000);
    //   window.setTimeout(() => {
    //     window.location.href = "https://authentische-momente.de";
    //   }, 5000);
    // },
  };
}
