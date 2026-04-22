import { z } from "zod";

const allowedHouseNumberSeparators = ["-", " "];

const CHAR_ERROR = "Bitte nur gültige Zeichen verwenden!";
const MIN_ERROR = "mindestens ein Zeichen!";
const MAX_ERROR = "maximal 6 Zeichen!";

const letterRegex = /\p{L}/u;
const digitRegex = /\d/;
const normalizationFormat = "NFC";

export const HouseNumberSchema = z
  .string()
  .trim()
  .min(1, MIN_ERROR)
  .max(7, MAX_ERROR)
  .transform((value: string) => value.normalize(normalizationFormat))
  .refine((value) => {
    return validateHouseNumber(value, allowedHouseNumberSeparators, digitRegex, letterRegex);
  }, CHAR_ERROR);

function validateHouseNumber(
  validationValue: string,
  allowedSeparators: Array<string>,
  digitRegex: RegExp,
  letterRegex: RegExp
) {
  let result = false;

  for (let i = 0; i < validationValue.length; i++) {
    let char = validationValue[i];

    if (digitRegex.test(char)) {
      result = true;
      continue;
    }

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
