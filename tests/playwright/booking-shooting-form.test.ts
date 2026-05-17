import { test, expect, Page } from "@playwright/test";
import { type Customer } from "@lib/validation/schemas/customer.schema.ts";
import { fakerDE } from "@faker-js/faker";
import { customerFormFields } from "../../resources/app/components/booking-shooting/booking.form.shape";

async function testIsBookingShootingFormLoaded(page: Page) {
  await expect(page.getByTestId(bookingShootingTestId)).toBeVisible();
  await expect(page.getByTestId(bookingShootingTestId)).toBeEnabled();
}

async function testShootingStep(
  page: Page,
  shootigsContainerTestId: string,
  shootingTitle: string,
  goNextButtonId: string,
  nextStepId: string
) {
  const timeOut = 3000;
  const shootings = page.getByTestId(shootigsContainerTestId);
  await expect(shootings).toBeVisible({ timeout: timeOut });
  await expect(shootings).toBeEnabled({ timeout: timeOut });
  const shooting = shootings.getByRole("button", { name: shootingTitle });
  await expect(shooting).toBeVisible({ timeout: timeOut });
  await expect(shooting).toBeEnabled({ timeout: timeOut });
  await shooting.click();
  const nextButton = page.getByTestId(goNextButtonId);
  await expect(nextButton).toBeVisible({ timeout: timeOut });
  await expect(nextButton).toBeEnabled({ timeout: timeOut });
  await nextButton.click();
  const nextStep = page.getByTestId(nextStepId);
  await expect(nextStep).toBeVisible({ timeout: timeOut });
  await expect(nextStep).toBeEnabled({ timeout: timeOut });
}

async function testParticipantsStep(
  page: Page,
  participantsStepTestId: string,
  goNextButtonId: string,
  nextStepTestId: string
) {
  const timeOut = 3000;
  const participants = page.getByTestId(participantsStepTestId);
  await participants.getByLabel("Erwachsene").fill("2");
  await participants.getByLabel("Haustiere").fill("1");
  const nextButton = page.getByTestId(goNextButtonId);
  await expect(nextButton).toBeVisible({ timeout: timeOut });
  await expect(nextButton).toBeEnabled({ timeout: timeOut });
  await nextButton.click();
  await expect(page.getByTestId(nextStepTestId)).toBeVisible();
}

async function testVariantsStep(
  page: Page,
  variantsTestId: string,
  goNextButtonId: string,
  nextStepTestId: string
) {
  const timeOut = 3000;
  const variant = page.getByTestId(variantsTestId).first();
  await expect(variant).toBeVisible();
  await expect(variant).toBeEnabled();
  await variant.click();
  const nextButton = page.getByTestId(goNextButtonId);
  await expect(nextButton).toBeVisible({ timeout: timeOut });
  await expect(nextButton).toBeEnabled({ timeout: timeOut });
  await nextButton.click();
  await expect(page.getByTestId(nextStepTestId)).toBeVisible();
}

async function testCustomerStep(
  page: Page,
  customerTestId: string,
  goNextButtonId: string,
  nextStepTestId: string
) {
  const testCustomer: Customer = {
    firstName: fakerDE.person.firstName(),
    lastName: fakerDE.person.lastName(),
    email: fakerDE.internet.email(),
    mobilePhone: fakerDE.phone.number({ style: "human" }),
    street: fakerDE.location.street(),
    houseNumber: fakerDE.location.buildingNumber(),
    zipCode: fakerDE.location.zipCode(),
    city: fakerDE.location.city(),
    gdpr: true,
    newsLetter: false,
    honeyPot: "",
  };

  const timeOut = 3000;
  const customer = page.getByTestId(customerTestId);
  await expect(customer).toBeVisible({ timeout: timeOut });
  await expect(customer).toBeEnabled({ timeout: timeOut });

  // firstName
  const firstNameData = customerFormFields.firstName;

  await customer.getByTestId(firstNameData.dataTestId).fill(testCustomer.firstName);
  const firstName = await customer.getByTestId(firstNameData.dataTestId).inputValue();
  expect(firstName).toBe(testCustomer.firstName);

  // lastName
  const lastNameData = customerFormFields.lastName;

  await customer.getByTestId(lastNameData.dataTestId).fill(testCustomer.lastName);
  const lastName = await customer.getByTestId(lastNameData.dataTestId).inputValue();
  expect(lastName).toBe(testCustomer.lastName);

  // email
  const emailData = customerFormFields.email;

  await customer.getByTestId(emailData.dataTestId).fill(testCustomer.email);
  const eMail = await customer.getByTestId(emailData.dataTestId).inputValue();
  expect(eMail).toBe(testCustomer.email);

  // mobile Phone
  const phoneData = customerFormFields.mobilePhone;

  await customer.getByTestId(phoneData.dataTestId).fill(testCustomer.mobilePhone);
  const mobilePhone = await customer.getByTestId(phoneData.dataTestId).inputValue();
  expect(mobilePhone).toBe(testCustomer.mobilePhone);

  // street
  const streetData = customerFormFields.street;

  await customer.getByTestId(streetData.dataTestId).fill(testCustomer.street);
  const street = await customer.getByTestId(streetData.dataTestId).inputValue();
  expect(street).toBe(testCustomer.street);

  // house Nm
  const houseNmData = customerFormFields.houseNumber;

  await customer.getByTestId(houseNmData.dataTestId).fill(testCustomer.houseNumber);
  const houseNumber = await customer.getByTestId(houseNmData.dataTestId).inputValue();
  expect(houseNumber).toBe(testCustomer.houseNumber);

  // city
  const cityData = customerFormFields.city;

  await customer.getByTestId(cityData.dataTestId).fill(testCustomer.city);
  const city = await customer.getByTestId(cityData.dataTestId).inputValue();
  expect(city).toBe(testCustomer.city);

  // zip code
  const zipCodeData = customerFormFields.zipCode;

  await customer.getByTestId(zipCodeData.dataTestId).fill(testCustomer.zipCode);
  const zipCode = await customer.getByTestId(zipCodeData.dataTestId).inputValue();
  expect(zipCode).toBe(testCustomer.zipCode);

  // gdpr
  const gdprData = customerFormFields.gdpr;

  await customer.getByTestId(gdprData.dataTestId).check();
  const gdpr = await customer.getByTestId(gdprData.dataTestId).isChecked();
  expect(gdpr).toBe(true);

  const nextButton = page.getByTestId(goNextButtonId);
  await expect(nextButton).toBeVisible({ timeout: timeOut });
  await expect(nextButton).toBeEnabled({ timeout: timeOut });
  await nextButton.click();
  await expect(page.getByTestId(nextStepTestId)).toBeVisible({ timeout: timeOut });
}

async function testCheckUpStep(page: Page, checkUpTestId: string, sendQueryButtonTestId: string) {
  const timeOut = 3000;
  const checkUpContainer = page.getByTestId(checkUpTestId).first();
  await expect(checkUpContainer).toBeVisible({ timeout: timeOut });
  await expect(checkUpContainer).toBeEnabled({ timeout: timeOut });

  const sendQueryButton = page.getByTestId(sendQueryButtonTestId);
  await expect(sendQueryButton).toBeVisible({ timeout: timeOut });
  await expect(sendQueryButton).toBeEnabled({ timeout: timeOut });
  await sendQueryButton.click();
}

const bookingShootingTestId = "booking-shooting-form";

const shootingsTestId = "booking-step-shootings";

const shooting = "Familie";

const participantsTestId = "booking-step-participants";

const variantsTestId = "booking-step-variants";

const customerTestId = "booking-step-customer";

const checkUpTestId = "booking-step-checkup";

const goNextButtonId = "go-next-button";

const sendQueryButton = "send-query-button";

test.beforeEach(async ({ page }) => {
  await page.goto("/buche-dein-shooting/");
});

test.skip("test if the booking form is loaded", async ({ page }) => {
  await testIsBookingShootingFormLoaded(page);
});

test.skip("step 1: check if shootings are loaded", async ({ page }) => {
  await testShootingStep(page, shootingsTestId, shooting, goNextButtonId, participantsTestId);
});

test.skip("step 2: run step 1 and 2 out participants", async ({ page }) => {
  await testShootingStep(page, shootingsTestId, shooting, goNextButtonId, participantsTestId);
  await testParticipantsStep(page, participantsTestId, goNextButtonId, variantsTestId);
});

test.skip("step 3: run step 1 & 2 and check one variant", async ({ page }) => {
  await testShootingStep(page, shootingsTestId, shooting, goNextButtonId, participantsTestId);
  await testParticipantsStep(page, participantsTestId, goNextButtonId, variantsTestId);
  await testVariantsStep(page, variantsTestId, goNextButtonId, customerTestId);
});

test.skip("step 4: run step 1 to 3 and fill out customer data", async ({ page }) => {
  await testShootingStep(page, shootingsTestId, shooting, goNextButtonId, participantsTestId);
  await testParticipantsStep(page, participantsTestId, goNextButtonId, variantsTestId);
  await testVariantsStep(page, variantsTestId, goNextButtonId, customerTestId);
  await testCustomerStep(page, customerTestId, goNextButtonId, checkUpTestId);
});

test("step 5: run step 1 to 4 and send data to api", async ({ page }) => {
  await testShootingStep(page, shootingsTestId, shooting, goNextButtonId, participantsTestId);
  await testParticipantsStep(page, participantsTestId, goNextButtonId, variantsTestId);
  await testVariantsStep(page, variantsTestId, goNextButtonId, customerTestId);
  await testCustomerStep(page, customerTestId, goNextButtonId, checkUpTestId);
  await testCheckUpStep(page, checkUpTestId, sendQueryButton);
});
