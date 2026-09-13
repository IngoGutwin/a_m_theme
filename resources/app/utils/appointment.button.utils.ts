const appointmetnButtons = document.querySelectorAll<HTMLButtonElement>(".contact-btn");

function loadListeners() {
  appointmetnButtons.forEach((button: HTMLButtonElement) => {
    let targetUrl = button.dataset.targetUrl;
    delete button.dataset.targetUrl;
    button.addEventListener("click", () => (window.location.href = targetUrl ? targetUrl : ""));
  });
}

export function initAppointmentButtons() {
  loadListeners();
}
