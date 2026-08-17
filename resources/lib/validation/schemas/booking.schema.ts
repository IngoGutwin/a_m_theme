import { z } from "zod";
import { CustomerSchema } from "./customer.schema";
import { ParticipantsSchema } from "./participants.schema";

const SHOOTING_REQUIRED = "Bitte wähle ein Fotoshooting.";

export const BookingDataSchema = z.object({
  title: z.string().min(1, SHOOTING_REQUIRED),
  productId: z.string().min(1, SHOOTING_REQUIRED),
  participants: ParticipantsSchema,
});

export type BookingData = z.infer<typeof BookingDataSchema>;

export const BookingFormSchema = z.object({
  customer: CustomerSchema,
  booking: BookingDataSchema,
});

export type BookingFormPayload = z.infer<typeof BookingFormSchema>;
