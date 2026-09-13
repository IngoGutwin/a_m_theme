import { z } from "zod";

const CHAR_ERROR = "Bitte nur gültige Zeichen verwenden!";
const MIN_ERROR = "mindestens vier Zeichen!";
const MAX_ERROR = "maximal sechs Zeichen!";

const digitRegex = /\d/;
const normalizationFormat = "NFC";

export const ZipCodeSchema = z.preprocess((value) => (value === "" ? undefined : value),
  z
  .string()
  .trim()
  .min(4, MIN_ERROR)
  .max(6, MAX_ERROR)
  .refine((v) => {
    if (!v) {
      return undefined;
    }
    let code = v.normalize(normalizationFormat);
    return validateZipCode(code, digitRegex);
  }, CHAR_ERROR)
  .optional()
)

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
