import { initNavBar } from "./utils/navbar.utils";
import { initSwiper } from "./utils/slider.utils";
import { initAppointmentButtons } from "./utils/appointment.button.utils";

document.addEventListener("DOMContentLoaded", () => {
  initNavBar();
  initSwiper();
  initAppointmentButtons();
});
