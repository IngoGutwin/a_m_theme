import { z } from "zod";

const allowedCityNameSeparators = ["-", "'", " ", ".", "/"];

const CHAR_ERROR = "Bitte nur gültige Zeichen verwenden!";
const MIN_ERROR = "mindestens zwei Zeichen!";
const MAX_ERROR = "maximal 65 Zeichen!";

const letterRegex = /\p{L}/u;
const normalizationFormat = "NFC";

export const CitySchema = z.preprocess((value) => (value === "" ? undefined : value),
  z
  .string()
  .trim()
  .min(2, MIN_ERROR)
  .max(68, MAX_ERROR)
  .transform((value: string) => value.normalize(normalizationFormat))
  .refine((value: string) => {
    return validateCity(value, allowedCityNameSeparators, letterRegex);
  }, CHAR_ERROR).optional()
);

function validateCity(
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
      if (i === 0) {
        return false;
      }
      continue;
    }

    return false;
  }
  return result;
}
