import { z } from "zod";

const EMAIL_ERROR = "Bitte eine gültige E-Mail angeben!";

export const EmailSchema = z.email(EMAIL_ERROR).trim();
