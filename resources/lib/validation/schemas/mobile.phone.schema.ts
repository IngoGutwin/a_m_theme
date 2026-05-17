import { z } from "zod";

const allowedPhoneNumberSeparators = [" ", "-", "(", ")", "+"];

const CHAR_ERROR = "Bitte nur Zahlen verwenden!";
const MIN_ERROR = "mindestens sieben Zeichen!";
const MAX_ERROR = "maximal 15 Zeichen!";

const digitRegex = /\d/;
const normalizationFormat = "NFC";

export const MobilePhoneSchema = z
  .string()
  .trim()
  .min(7, MIN_ERROR)
  .max(20, MAX_ERROR)
  .refine((v) => {
    let number = v.normalize(normalizationFormat);
    return validatePhoneNumber(number, allowedPhoneNumberSeparators, digitRegex);
  }, CHAR_ERROR);

function validatePhoneNumber(
  validationValue: string,
  allowedSeparators: Array<string>,
  digitRegex: RegExp
) {
  for (let i = 0; i < validationValue.length; i++) {
    let char = validationValue[i];

    if (digitRegex.test(char)) {
      continue;
    }

    if (allowedSeparators.includes(char)) {
      if (char === "+" && i !== 0) {
        return false;
      }
      continue;
    }

    return false;
  }

  return true;
}
