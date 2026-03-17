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
          adults: 0,
          childrens: 20,
          animals: 30,
          toddlers: 20,
        };
      });

      notValidParticipants.forEach((item: Participants) => {
        let result = ParticipantsSchema.safeParse(item);
        expect(result.success).toBe(false);
      });
    });
  });
});
