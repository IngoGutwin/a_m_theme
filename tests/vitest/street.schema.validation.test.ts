import { describe, it, expect } from "vitest";
import { StreetSchema } from "@lib/validation/schemas/customer.schema";
import { fakerDE } from "@faker-js/faker";

// Test streetSchemas
describe("Test StreetSchema", () => {
  it("tests valid first char", () => {
    const validStreetName = fakerDE.location.street();
    let result = StreetSchema.safeParse(validStreetName);
    expect(result.success).toBe(true);
  });

  it("tests not valid first char", () => {
    const notValidName = "-" + fakerDE.location.street();
    let result = StreetSchema.safeParse(notValidName);
    expect(result.success).toBe(false);
  });

  it("tests special chars", () => {
    const notValidName = "Fah/ren[heit{str]aße";
    let result = StreetSchema.safeParse(notValidName);
    expect(result.success).toBe(false);
  });

  it("accepts valid street names", () => {
    const validStreetNames = Array.from({ length: 100 }, () => {
      let name = fakerDE.location.street();
      return name;
    });

    validStreetNames.forEach((name: string) => {
      let result = StreetSchema.safeParse(name);
      expect(result.success).toBe(true);
    });
  });

  it("tests malicious street names", () => {
    const validStreetNames = Array.from({ length: 100 }, (_, i) => {
      let name = `<script>console.log("Hello nm ${i}");</script>`;
      return name;
    });

    validStreetNames.forEach((name: string) => {
      let result = StreetSchema.safeParse(name);
      expect(result.success).toBe(false);
    });
  });
});
