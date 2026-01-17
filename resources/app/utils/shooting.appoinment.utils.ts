async function loadApp(rootComponent: HTMLElement) {
  const { createApp } = await import("vue");
  const AppoinmentBooking = await import("./../components/AppoinmentBooking.vue");
  createApp(AppoinmentBooking.default).mount(rootComponent);
}

export function initShootingAppoinment() {
  let shootingAppoinment = document.querySelector<HTMLElement>(
    "#shooting-appoinment-booking-section"
  );
  if (shootingAppoinment) {
    loadApp(shootingAppoinment);
  }
}
