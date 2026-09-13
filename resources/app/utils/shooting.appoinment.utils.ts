import Alpine from "alpinejs";
import { bookingForm } from "../booking/booking.form";

declare global {
  interface Window {
    Alpine: typeof Alpine;
  }
}

export function initShootingAppoinment() {
  window.Alpine = Alpine;
  Alpine.data("bookingForm", bookingForm);
  Alpine.start();
}
