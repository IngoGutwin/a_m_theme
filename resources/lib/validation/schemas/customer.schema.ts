import { z } from "zod";

function validateName(value: string) {
  value = value.normalize("NFC");

  let result = true;
  let allowedNameSeparators = ["-", "'", " "];
  let allowedNameRegex = /\p{L}/u;

  for (let i = 0; i < value.length; i++) {
    let char = value[i];

    if (allowedNameSeparators.includes(char)) {
      if (i === 0 || i === value.length) {
        result = false;
        break;
      }
    }

    if (!allowedNameRegex.test(char)) {
      result = false;
      break;
    }
  }
  return result;
}

export const NameSchema = z
  .string()
  .trim()
  .min(2, "Mindestens zwei Zeichen!")
  .max(36, "Darf maximal 36 Zeichen sein!")
  .refine(validateName, "keine Sonderzeichen in Namen!");

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
