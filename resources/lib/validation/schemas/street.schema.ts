import { z } from "zod";

const allowedStreetNameSeparators = ["-", "'", " ", ".", "/"];

const CHAR_ERROR = "Bitte nur gültige Zeichen verwenden!";
const MIN_ERROR = "mindestens zwei Zeichen!";
const MAX_ERROR = "maximal 65 Zeichen!";

const letterRegex = /\p{L}/u;
const digitRegex = /\d/;
const normalizationFormat = "NFC";

export const StreetSchema = z.preprocess(
  (value) => (value === "" ? undefined : value),
  z
    .string()
    .trim()
    .min(2, MIN_ERROR)
    .max(65, MAX_ERROR)
    .transform((value: string) => value.normalize(normalizationFormat))
    .refine((value) => {
      return validateStreet(value, allowedStreetNameSeparators, letterRegex, digitRegex);
    }, CHAR_ERROR)
    .optional()
);

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
