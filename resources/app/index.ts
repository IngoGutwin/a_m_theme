import { initNavBar } from "./lib/navbar.utils";
import { initSwiper } from "./lib/slider.utils";
import { initAppointmentButtons } from "./lib/appointment.button.utils";

document.addEventListener("DOMContentLoaded", () => {
  initNavBar();
  initSwiper();
  initAppointmentButtons();
});
