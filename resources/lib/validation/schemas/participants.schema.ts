import { z } from "zod";

export const MIN_PERSONS = 1;
export const MIN_PERSONS_MESSAGE = `min. ${MIN_PERSONS}`;
export const MAX_PERSONS = 8;
export const MAX_PERSONS_MESSAGE = `max. ${MAX_PERSONS}`;
export const GIVE_A_NUMBER = "Bitte eine Zahl eingeben!";

export const ParticipantsSchema = z.object({
  adults: z.preprocess(
    (v: string) => Number.parseInt(v),
    z
      .int({ error: GIVE_A_NUMBER })
      .min(0)
      .max(MAX_PERSONS, MAX_PERSONS_MESSAGE)
  ),
  childrens: z.preprocess(
    (v: string) => Number.parseInt(v),
    z.int({ error: GIVE_A_NUMBER }).min(0).max(MAX_PERSONS, MAX_PERSONS_MESSAGE)
  ),
  toddlers: z.preprocess(
    (v: string) => Number.parseInt(v),
    z.int({ error: GIVE_A_NUMBER }).min(0).max(MAX_PERSONS, MAX_PERSONS_MESSAGE)
  ),
  animals: z.preprocess(
    (v: string) => Number.parseInt(v),
    z.int({ error: GIVE_A_NUMBER }).min(0).max(MAX_PERSONS, MAX_PERSONS_MESSAGE)
  ),
});

export type Participants = z.infer<typeof ParticipantsSchema>;
