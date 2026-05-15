import { test, expect, Page } from "@playwright/test";
import { type Customer } from "../../resources/lib/validation/schemas/customer.schema.ts";

async function testIsBookingShootingFormLoaded(page: Page) {
  await expect(page.getByTestId(bookingShootingTestId)).toBeVisible();
  await expect(page.getByTestId(bookingShootingTestId)).toBeEnabled();
}

async function testShootingStep(
  page: Page,
  shooting: string,
  shootigsTestId: string,
  nextStepButton: string,
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

async function testCustomerStep(page: Page, customerTestId: string, nextStepTestId?: string) {
  const testCustomer: Customer = {
    firstName: "David",
    lastName: "Bowie",
    email: "david.bowie@gmail.com",
    mobilePhone: "015143568769",
    street: "Fahrenheitstraße",
    houseNumber: "10B",
    zipCode: "45456",
    city: "Berlin",
    gdpr: true,
    newsLetter: false,
  };

  const customer = page.getByTestId(customerTestId);
  await expect(customer).toBeVisible();
  await expect(customer).toBeEnabled();

  await customer.getByTestId("first-name").fill(testCustomer.firstName);
  const firstName = await customer.getByTestId("first-name").inputValue();
  expect(firstName).toBe(testCustomer.firstName);

  await customer.getByTestId("last-name").fill(testCustomer.lastName);
  const lastName = await customer.getByTestId("last-name").inputValue();
  expect(lastName).toBe(testCustomer.lastName);

  await customer.getByTestId("e-mail").fill(testCustomer.email);
  const eMail = await customer.getByTestId("e-mail").inputValue();
  expect(eMail).toBe(testCustomer.email);

  await customer.getByTestId("mobile-phone").fill(testCustomer.mobilePhone);
  const mobilePhone = await customer.getByTestId("mobile-phone").inputValue();
  expect(mobilePhone).toBe(testCustomer.mobilePhone);

  await customer.getByTestId("street-name").fill(testCustomer.street);
  const street = await customer.getByTestId("street-name").inputValue();
  expect(street).toBe(testCustomer.street);

  await customer.getByTestId("house-number").fill(testCustomer.houseNumber);
  const houseNumber = await customer.getByTestId("house-number").inputValue();
  expect(houseNumber).toBe(testCustomer.houseNumber);

  await customer.getByTestId("zip-code").fill(testCustomer.zipCode);
  const zipCode = await customer.getByTestId("zip-code").inputValue();
  expect(zipCode).toBe(testCustomer.zipCode);

  await customer.getByTestId("gdpr").check();
  const gdpr = await customer.getByTestId("gdpr").isChecked();
  expect(gdpr).toBe(true);
}

const bookingShootingTestId = "booking-shooting-form";

const shootingsTestId = "booking-step-shootings";

const shooting = "Familie";

const participantsTestId = "booking-step-participants";

const variantsTestId = "booking-step-variants";

const customerTestId = "booking-step-customer";

const nextButton = "go-next-button";

const sendQueryButton = "send-query-button";

test.beforeEach(async ({ page }) => {
  await page.goto("/buche-dein-shooting/");
});

test.skip("test if the booking form is loaded", async ({ page }) => {
  await testIsBookingShootingFormLoaded(page);
});

test("step 1: check if shootings are loaded", async ({ page }) => {
  await testShootingStep(page, shooting, shootingsTestId, participantsTestId);
});

test.skip("step 2: run step 1 and fill out participants", async ({ page }) => {
  await testShootingStep(page, shooting, shootingsTestId, participantsTestId);
  await testParticipantsStep(page, participantsTestId, variantsTestId);
});

test.skip("step 3: run step 1 & 2 and check one variant", async ({ page }) => {
  await testShootingStep(page, shooting, shootingsTestId, participantsTestId);
  await testParticipantsStep(page, participantsTestId, variantsTestId);
  await testVariantsStep(page, variantsTestId, customerTestId);
});

test.skip("step 4: run step 1 to 3 and fill out customer data", async ({ page }) => {
  await testShootingStep(page, shooting, shootingsTestId, participantsTestId);
  await testParticipantsStep(page, participantsTestId, variantsTestId);
  await testVariantsStep(page, variantsTestId, customerTestId);
  await testCustomerStep(page, customerTestId);
});
