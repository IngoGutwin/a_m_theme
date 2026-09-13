import { describe, it, expect } from "vitest";
import { ZipCodeSchema } from "@lib/validation/schemas/customer.schema";
import { fakerDE } from "@faker-js/faker";

// Test streetSchemas
describe("Test Zip Code Schema", () => {
  it("tests valid digits", () => {
    const validZipCode = fakerDE.location.zipCode();
    let result = ZipCodeSchema.safeParse(validZipCode);
    expect(result.success).toBe(true);
  });

  it("tests not valid digits", () => {
    const validZipCode = fakerDE.location.zipCode() + "a";
    let result = ZipCodeSchema.safeParse(validZipCode);
    expect(result.success).toBe(false);
  });

  it("tests not valid digits", () => {
    const validZipCode = fakerDE.location.zipCode() + "[";
    let result = ZipCodeSchema.safeParse(validZipCode);
    expect(result.success).toBe(false);
  });
});
