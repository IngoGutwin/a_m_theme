import { z } from "zod";

const allowedNameSeparators = ["-", "'", " "];

const CHAR_ERROR = "Bitte nur gültige Zeichen verwenden!";
const MIN_ERROR = "mindestens zwei Zeichen!";
const MAX_ERROR = "maximal 65 Zeichen!";

const letterRegex = /\p{L}/u;
const normalizationFormat = "NFC";

export const NameSchema = z.preprocess(
  (value) => (value === "" ? "" : value),
  z
    .string()
    .trim()
    .min(2, MIN_ERROR)
    .max(65, MAX_ERROR)
    .transform((value: string) => value.normalize(normalizationFormat))
    .refine((value: string) => {
      return validateName({
        validationValue: value,
        allowedSeparators: allowedNameSeparators,
        letterRegex,
      });
    }, CHAR_ERROR)
);

function validateName({
  validationValue,
  allowedSeparators,
  letterRegex,
}: {
  validationValue: string;
  allowedSeparators: Array<string>;
  letterRegex: RegExp;
}): boolean {
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
