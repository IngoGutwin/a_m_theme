import { test, expect } from "@playwright/test";

test.beforeEach(async ({ page }) => {
  await page.goto("/");
});

test("page is avalable", async ({ page }) => {
  await expect(page).toHaveTitle("authentische momente");
});

test("hero section is visible", async ({ page }) => {
  const heroSection = page.getByTestId("hero-section");
  await expect(heroSection).toBeVisible();
});

test("call to action button is visible", async ({ page }) => {
  const button = page.getByTestId("hero-section").getByRole("button", { name: "Termin buchen!" });
  await expect(button).toBeVisible();
});

test("click call to action button v1", async ({ page }) => {
  const ctaButton = page
    .getByTestId("hero-section")
    .getByRole("button", { name: "Termin buchen!" });
  await expect(ctaButton).toBeVisible();
  await expect(ctaButton).toBeEnabled();
  await Promise.all([ctaButton.click(), page.waitForURL("/buche-dein-shooting/")]);
  await expect(page.getByTestId("booking-shooting-form")).toBeVisible();
});
