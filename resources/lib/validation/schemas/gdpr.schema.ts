import { z } from "zod";

const GDPR_ERROR = "Bitte bestätige, dass du die Datenschutzhinweise zur Kentniss genommen hast!";

export const GdprSchema = z
  .boolean()
  .default(false)
  .refine((value) => value, GDPR_ERROR);

export const NewsletterSchema = z.boolean().default(false);
