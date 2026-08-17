import { initNavBar } from "./utils/navbar.utils";
import { initSwiper } from "./utils/slider.utils";
import { initAppointmentButtons } from "./utils/appointment.button.utils";
import { initAppoinmentUtils } from "./appoinment.entry";


document.addEventListener("DOMContentLoaded", () => {
  initNavBar();
  initSwiper();
  initAppointmentButtons();
  initAppoinmentUtils();
});
