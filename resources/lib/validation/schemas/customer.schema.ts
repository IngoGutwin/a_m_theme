import { z } from "zod";

const allowedSeparators = ["-", "'", " "];

function validateName(name: string) {}

export const NameSchema = z
  .string()
  .trim()
  .min(2, "Mindestens zwei Zeichen!")
  .max(36, "Darf maximal 36 Zeichen sein!")
  .refine((v) => {
    return validateName(v);
  }, "Ungültiger Name!");

export const StreetSchema = z
  .string()
  .trim()
  .refine((v) => {
    // console.log(v);
  }, "Ungültige Straße!");

export const EmailSchema = z.email("Ungültige Email Adresse!").trim();

export const ZipCodeSchema = z
  .string()
  .trim()
  .refine((v) => {
    // console.log(v);
  });

const HouseNumberSchema = z.string().trim().min(1, "Haus Nummer fehlt.");

const GdprSchema = z.boolean().default(false);

export const CustomerSchema = z.object({
  firstName: NameSchema,
  lastName: NameSchema,
  email: EmailSchema,
  street: StreetSchema,
  city: StreetSchema,
  zipCode: ZipCodeSchema,
  houseNm: HouseNumberSchema,
  gdpr: GdprSchema,
});
