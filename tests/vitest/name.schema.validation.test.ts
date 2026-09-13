import { describe, it, expect } from "vitest";
import { NameSchema } from "@lib/validation/schemas/customer.schema";
import { fakerDE } from "@faker-js/faker";

// Test nameSchemas
describe("Test NameSchema", () => {
  it("tests valid first char", () => {
    const validName = "Adam";
    let result = NameSchema.safeParse(validName);
    expect(result.success).toBe(true);
  });

  it("tests not valid first char", () => {
    const notValidName = "-Adam";
    let result = NameSchema.safeParse(notValidName);
    expect(result.success).toBe(false);
  });

  it("tests special chars", () => {
    const notValidName = "-A/[m";
    let result = NameSchema.safeParse(notValidName);
    expect(result.success).toBe(false);
  });

  it("accepts valid first names", () => {
    const validFirstNames = Array.from({ length: 100 }, () => {
      let name = fakerDE.person.firstName();
      return name;
    });

    validFirstNames.forEach((name: string) => {
      let result = NameSchema.safeParse(name);
      expect(result.success).toBe(true);
    });
  });

  it("tests not valid last char", () => {
    const notValidName = "Adam-";
    let result = NameSchema.safeParse(notValidName);
    expect(result.success).toBe(false);
  });

  it("tests valid last names", () => {
    const validLastNames = Array.from({ length: 100 }, () => {
      let name = fakerDE.person.lastName();
      return name;
    });

    validLastNames.forEach((name: string) => {
      let result = NameSchema.safeParse(name);
      expect(result.success).toBe(true);
    });
  });

  it("tests valid middle names", () => {
    const validMiddleNames = Array.from({ length: 100 }, () => {
      let name = fakerDE.person.middleName();
      return name;
    });

    validMiddleNames.forEach((name: string) => {
      let result = NameSchema.safeParse(name);
      expect(result.success).toBe(true);
    });
  });

  it("tests not valid middle names", () => {
    const validMiddleNames = Array.from({ length: 100 }, () => {
      let name = fakerDE.internet.email();
      return name;
    });

    validMiddleNames.forEach((name: string) => {
      let result = NameSchema.safeParse(name);
      expect(result.success).toBe(false);
    });
  });

  it("tests malicious html", () => {
    const maliciousNames = Array.from({ length: 100 }, () => {
      let name = fakerDE.person.middleName();
      return name;
    });

    maliciousNames.forEach((name: string, i: number) => {
      let malName = name + `<script>let ${i} = 'Hello World!'</script>`;
      let result = NameSchema.safeParse(malName);
      expect(result.success).toBe(false);
    });
  });
});
