import { test, expect, type Page } from "@playwright/test";
import type { Customer } from "@lib/validation/schemas/customer.schema.ts";
import { fakerDE } from "@faker-js/faker";

const bookingShootingTestId = "booking-shooting-form";
const shootingsTestId = "booking-step-shootings";
const participantsTestId = "booking-step-participants";
const customerTestId = "booking-step-customer";
const sendQueryButton = "send-query-button";
const shooting = "Familie";

async function fillBookingForm(page: Page) {
  const timeOut = 5000;

  await expect(page.getByTestId(bookingShootingTestId)).toBeVisible({ timeout: timeOut });

  const shootings = page.getByTestId(shootingsTestId);
  await expect(shootings).toBeVisible({ timeout: timeOut });
  await shootings.getByTestId("shooting-select").selectOption({ label: shooting });

  const participants = page.getByTestId(participantsTestId);
  await participants.getByLabel("Erwachsene").fill("2");
  await participants.getByLabel("Haustiere").fill("1");

  const testCustomer: Customer = {
    firstName: fakerDE.person.firstName(),
    lastName: fakerDE.person.lastName(),
    email: fakerDE.internet.email(),
    mobilePhone: "01701234567",
    street: "Musterstraße",
    houseNumber: "12",
    zipCode: "12345",
    city: "Berlin",
    gdpr: true,
    newsLetter: false,
    honeyPot: "",
  };

  const customer = page.getByTestId(customerTestId);
  await customer.getByTestId("first-name").fill(testCustomer.firstName);
  await customer.getByTestId("last-name").fill(testCustomer.lastName);
  await customer.getByTestId("e-mail").fill(testCustomer.email);
  await customer.getByTestId("mobile-phone").fill(testCustomer.mobilePhone);
  await customer.getByTestId("street-name").fill(testCustomer.street);
  await customer.getByTestId("house-number").fill(testCustomer.houseNumber);
  await customer.getByTestId("zip-code").fill(testCustomer.zipCode);
  await customer.getByTestId("city-name").fill(testCustomer.city);
  await customer.getByTestId("gdpr-check").check();

  return testCustomer;
}

test.beforeEach(async ({ page }) => {
  await page.goto("/buche-dein-shooting/");
});

test("single-step booking form loads and submits", async ({ page }) => {
  await fillBookingForm(page);

  const submit = page.getByTestId(sendQueryButton);
  await expect(submit).toBeVisible();
  await expect(submit).toBeEnabled();
  await submit.click();
});
