import { describe, it, expect } from "vitest";
import { MobilePhoneSchema } from "@lib/validation/schemas/customer.schema";
import { fakerDE } from "@faker-js/faker";

// Test streetSchemas
describe("Test mobile phone input", () => {
  it.skip("tests valid number", () => {
    const validPhoneNumber = fakerDE.phone.number();
    let result = MobilePhoneSchema.safeParse(validPhoneNumber);
    expect(result.success).toBe(true);
  });

  it("tests a set of mobile numbers", () => {
    const validPhoneNumbers = Array.from({ length: 100 }, () => fakerDE.phone.number());
    validPhoneNumbers.forEach((telNumber: string) => {
      let result = MobilePhoneSchema.safeParse(telNumber);
      expect(result.success).toBe(true);
    });
  });

  it("tests a set of not valid numbers", () => {
    const validPhoneNumber = fakerDE.phone.number();
    let maliciousNumber = validPhoneNumber + "<script>let hello = 'Hello World'</script>";
    let result = MobilePhoneSchema.safeParse(maliciousNumber);
    expect(result.success).toBe(false);
  });
});
