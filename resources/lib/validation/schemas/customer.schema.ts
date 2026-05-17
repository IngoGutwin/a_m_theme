import { z } from "zod";
import {
  NameSchema,
  MobilePhoneSchema,
  StreetSchema,
  CitySchema,
  ZipCodeSchema,
  HouseNumberSchema,
  EmailSchema,
  GdprSchema,
  NewsletterSchema,
} from "./index.ts";

export const CustomerSchema = z.object({
  firstName: NameSchema,
  lastName: NameSchema,
  email: EmailSchema,
  mobilePhone: MobilePhoneSchema,
  street: StreetSchema,
  city: CitySchema,
  zipCode: ZipCodeSchema,
  houseNumber: HouseNumberSchema,
  gdpr: GdprSchema,
  newsLetter: NewsletterSchema,
  honeyPot: z.string(),
});

export type Customer = z.infer<typeof CustomerSchema>;
