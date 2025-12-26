async function loadApp(rootComponent: HTMLElement) {
  const { createApp } = await import("vue");
  const AppoinmentBooking = await import("./../components/AppoinmentBooking.vue");
  createApp(AppoinmentBooking.default).mount(rootComponent);
}

export function initShootingAppoinment() {
  let shootingAppoinment = document.querySelector<HTMLElement>("#shooting-appoinment");
  if (shootingAppoinment) {
    loadApp(shootingAppoinment);
  };
}
