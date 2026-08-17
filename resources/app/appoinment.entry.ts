export async function initAppoinmentUtils() {
  const root = document.querySelector<HTMLElement>("#shooting-appoinment-booking-section");
  if (!root) {
    return;
  };
  const { initShootingAppoinment } = await import("./utils/shooting.appoinment.utils");
  initShootingAppoinment();
}
