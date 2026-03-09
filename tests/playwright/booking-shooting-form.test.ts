import { test, expect, Page } from "@playwright/test";

const bookingShootingTestId = "booking-shooting-form";

const shootingsTestId = "booking-step-shootings";
const shooting = "Familie";

const participantsTestId = "booking-step-participants";

const variantsTestId = "booking-step-variants";

const customerTestId = "booking-step-customer";

test.beforeEach(async ({ page }) => {
  await page.goto("/buche-dein-shooting/");
});

async function testIsBookingShootingFormLoaded(page: Page) {
  await expect(page.getByTestId(bookingShootingTestId)).toBeVisible();
  await expect(page.getByTestId(bookingShootingTestId)).toBeEnabled();
}

async function testShootingStep(
  page: Page,
  shooting: string,
  shootigsTestId: string,
  nextStepTestId: string
) {
  const shootings = page.getByTestId(shootigsTestId);
  await expect(shootings).toBeVisible();
  await expect(shootings).toBeEnabled();
  const button = shootings.getByRole("button", { name: shooting });
  await expect(button).toBeVisible();
  await expect(button).toBeEnabled();
  await button.click();
  await expect(page.getByTestId(nextStepTestId)).toBeVisible();
}

async function testParticipantsStep(
  page: Page,
  participantsStepTestId: string,
  nextStepTestId: string
) {
  const participants = page.getByTestId(participantsStepTestId);
  await participants.getByLabel("Erwachsene").fill("2");
  await participants.getByLabel("Haustiere").fill("1");
  const button = page.getByRole("button", { name: "weiter" });
  await button.click();
  await expect(page.getByTestId(nextStepTestId)).toBeVisible();
}

async function testVariantsStep(page: Page, variantsTestId: string, nextStepTestId: string) {
  const variant = page.getByTestId(variantsTestId).first();
  await expect(variant).toBeVisible();
  await expect(variant).toBeEnabled();
  await variant.click();
  await expect(page.getByTestId(nextStepTestId)).toBeVisible();
}

async function testCustomerStep(page: Page, customerTestId: string, nextStepTestId: string) {
  const customer = page.getByTestId(customerTestId);
  await customer.getByLabel("Vorname").fill("2");
  // await participants.getByLabel("Haustiere").fill("1");
}

// test("test if the booking form is loaded", async ({ page }) => {
//   await testIsBookingShootingFormLoaded(page);
// });

// test("step 1: check if shootings are loaded", async ({ page }) => {
//   await testShootingStep(page, shooting, shootingsTestId, participantsTestId);
// });

// test("step 2: run step 1 and fill out participants", async ({ page }) => {
//   await testShootingStep(page, shooting, shootingsTestId, participantsTestId);
//   await testParticipantsStep(page, participantsTestId, variantsTestId);
// });

// test("step 3: run step 1 & 2 and check one variant", async ({ page }) => {
//   await testShootingStep(page, shooting, shootingsTestId, participantsTestId);
//   await testParticipantsStep(page, participantsTestId, variantsTestId);
//   await testVariantsStep(page, variantsTestId, customerTestId);
// });

test("step 4: run step 1 to 3 and fill out customer data", async ({ page }) => {
  await testShootingStep(page, shooting, shootingsTestId, participantsTestId);
  await testParticipantsStep(page, participantsTestId, variantsTestId);
  await testVariantsStep(page, variantsTestId, customerTestId);
});
