import { loadGlobalVariables } from "../config/global";

const appointmetnButtons = document.querySelectorAll<HTMLButtonElement>(".book-appointment-btn");
const globalVariables = loadGlobalVariables();

function loadListeners() {
  if (globalVariables) {
    appointmetnButtons.forEach((button: HTMLButtonElement) => {
      button.addEventListener(
        "click",
        () => (window.location.href = globalVariables.contactPageUrl)
      );
    });
  }
}

export function initAppointmentButtons() {
  loadListeners();
}
