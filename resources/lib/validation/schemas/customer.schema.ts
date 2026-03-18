import { z } from "zod";

const allowedNameSeparators = ["-", "'", " "];
let allowedStreetNameSeparators = ["-", "'", " ", ".", "/"];
const letterRegex = /\p{L}/u;
let digitRegex = /\d/;

export const NameSchema = z
  .string()
  .trim()
  .min(2, "Mindestens zwei Zeichen!")
  .max(36, "Darf maximal 36 Zeichen sein!")
  .refine((v) => {
    let name = v.normalize("NFC");
    return validateName(name, allowedNameSeparators, letterRegex);
  }, "keine Sonderzeichen in Namen!");

export const StreetSchema = z
  .string()
  .trim()
  .min(2)
  .max(68)
  .refine((v) => {
    let name = v.normalize("NFC");
    return validateStreet(name, allowedStreetNameSeparators, letterRegex, digitRegex);
  }, "keine gültige Adresse!");

export const EmailSchema = z.email("Ungültige Email Adresse!").trim();

export const ZipCodeSchema = z
  .string()
  .trim()
  .refine((v) => {
    let code = v.normalize("NFC");
    return validateZipCode(code, digitRegex);
  }, "kein gültiger Wert!");

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

function validateZipCode(validationValue: string, digitRegex: RegExp) {
  let result = false;

  for (let i = 0; i < validationValue.length; i++) {
    let char = validationValue[i];

    if (digitRegex.test(char)) {
      result = true;
      continue;
    }

    return false;
  }

  return result;
}

function validateStreet(
  validationValue: string,
  allowedSeparators: Array<string>,
  letterRegex: RegExp,
  digitRegex: RegExp
) {
  let result = false;

  for (let i = 0; i < validationValue.length; i++) {
    let char = validationValue[i];

    if (letterRegex.test(char)) {
      result = true;
      continue;
    }

    if (digitRegex.test(char)) {
      continue;
    }

    if (allowedSeparators.includes(char)) {
      if (i === 0) {
        return false;
      }
      continue;
    }

    return false;
  }
  return result;
}

function validateName(
  validationValue: string,
  allowedSeparators: Array<string>,
  letterRegex: RegExp
) {
  let result = false;

  for (let i = 0; i < validationValue.length; i++) {
    let char = validationValue[i];

    if (letterRegex.test(char)) {
      result = true;
      continue;
    }

    if (allowedSeparators.includes(char)) {
      if (i === 0 || i === validationValue.length - 1) {
        return false;
      }
      continue;
    }

    return false;
  }
  return result;
}
