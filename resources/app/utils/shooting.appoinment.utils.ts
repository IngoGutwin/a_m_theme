async function loadApp(rootComponent: HTMLElement) {
  const { createApp } = await import("vue");
  const BookingShooting = await import("@app/components/booking-shooting/BookingShooting.vue");
  createApp(BookingShooting.default).mount(rootComponent);
}

export function initShootingAppoinment() {
  let shootingAppoinment = document.querySelector<HTMLElement>(
    "#shooting-appoinment-booking-section"
  );
  if (shootingAppoinment) {
    loadApp(shootingAppoinment);
  }
}
