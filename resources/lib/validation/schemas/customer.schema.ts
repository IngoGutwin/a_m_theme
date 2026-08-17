import { z } from "zod";
import {
  NameSchema,
  MobilePhoneSchema,
  EmailSchema,
  GdprSchema,
  NewsletterSchema,
} from "./index.ts";

export const CustomerSchema = z.object({
  firstName: NameSchema,
  lastName: NameSchema,
  email: EmailSchema,
  mobilePhone: MobilePhoneSchema,
  message: z.string(),
  gdpr: GdprSchema,
  newsLetter: NewsletterSchema,
  honeyPot: z.string(),
});

export type Customer = z.infer<typeof CustomerSchema>;
