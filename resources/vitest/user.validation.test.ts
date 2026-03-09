import { describe, it, expect } from "vitest";
import { NameSchema, EmailSchema } from "@lib/validation/schemas/customer.schema";
import {
  Participants,
  ParticipantsSchema,
  MIN_PERSONS,
  MAX_PERSONS,
} from "@lib/validation/schemas/participants.schema";
import { fakerDE } from "@faker-js/faker";

describe("User Data Validation Test", () => {
  // Test Participants Schema
  describe("Participants Schema", () => {
    it("accepts a valid Participants object", () => {
      const validParticipants = Array.from({ length: 100 }, (): Participants => {
        return {
          adults: fakerDE.number.int({ min: MIN_PERSONS, max: MAX_PERSONS }),
          childrens: fakerDE.number.int({ max: MAX_PERSONS }),
          animals: fakerDE.number.int({ max: MAX_PERSONS }),
          toddlers: fakerDE.number.int({ max: MAX_PERSONS }),
        };
      });

      validParticipants.forEach((item: Participants) => {
        let result = ParticipantsSchema.safeParse(item);
        expect(result.success).toBe(true);
      });
    });

    it("accepts a not valid Participants object", () => {
      const notValidParticipants = Array.from({ length: 100 }, (): Participants => {
        return {
          adults: fakerDE.number.int({ min: MAX_PERSONS + 1 }),
          childrens: fakerDE.number.int({ min: MAX_PERSONS + 1 }),
          animals: fakerDE.number.int({ min: MAX_PERSONS + 1 }),
          toddlers: fakerDE.number.int({ min: MAX_PERSONS + 1 }),
        };
      });

      notValidParticipants.forEach((item: Participants) => {
        let result = ParticipantsSchema.safeParse(item);
        expect(result.success).toBe(false);
      });
    });
  });

  // Test nameSchemas
  describe("NameSchema", () => {
    it("accepts valid first names", () => {
      const validFirstNames = Array.from({ length: 100 }, () => {
        return fakerDE.person.firstName();
      });

      validFirstNames.forEach((name) => {
        let result = NameSchema.safeParse(name);
        expect(result.success).toBe(true);
      });
    });

    it("accepts hyphenated first + middle names", () => {
      const validFirstMiddleNames = Array.from({ length: 100 }, () => {
        return `${fakerDE.person.firstName()}-${fakerDE.person.middleName()}`;
      });

      validFirstMiddleNames.forEach((name) => {
        let result = NameSchema.safeParse(name);
        expect(result.success).toBe(true);
      });
    });

    it("accepts last names", () => {
      const validLastNames = Array.from({ length: 100 }, () => {
        return fakerDE.person.lastName();
      });

      validLastNames.forEach((name) => {
        let result = NameSchema.safeParse(name);
        expect(result.success).toBe(true);
      });
    });
  });

  describe("Email validation Test", () => {
    it("accepts valid e-mail adress", () => {
      const validEmails = Array.from({ length: 100 }, () => {
        return fakerDE.internet.email();
      });

      validEmails.forEach((email) => {
        let result = EmailSchema.safeParse(email);
        expect(result.success).toBe(true);
      });
    });
  });
});
