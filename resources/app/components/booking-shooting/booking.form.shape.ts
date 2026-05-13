import type { Customer } from "@lib/validation/schemas/customer.schema";
import type { Participants } from "@lib/validation/schemas/participants.schema";

interface BookingFormFields {
  label: string;
  id: string;
  type: string;
  required: boolean;
  dataTestId: string;
  autocomplete?: string;
  link?: string;
}

export const participantsFormFields: Record<keyof Participants, BookingFormFields> = {
  adults: {
    label: "Erwachsene",
    id: "adults",
    type: "text",
    required: true,
    dataTestId: "adults-test-id",
    autocomplete: "on",
  },
  childrens: {
    label: "Kinder ab zwei Jahren",
    id: "adults",
    type: "text",
    required: true,
    dataTestId: "children-test-id",
    autocomplete: "on",
  },
  animals: {
    label: "Haustiere",
    id: "adults",
    type: "text",
    required: true,
    dataTestId: "animals-test-id",
    autocomplete: "on",
  },
  toddlers: {
    label: "Kinder bis zwei Jahren",
    id: "togglers",
    type: "text",
    required: true,
    dataTestId: "toddlers-test-id",
    autocomplete: "on",
  },
};

export const customerFormFields: Record<keyof Customer, BookingFormFields> = {
  firstName: {
    label: "Vorname",
    id: "firstName",
    type: "text",
    required: true,
    dataTestId: "first-name",
    autocomplete: "on",
  },
  lastName: {
    label: "Nachname",
    id: "lastName",
    type: "text",
    required: true,
    dataTestId: "last-name",
    autocomplete: "on",
  },
  city: {
    label: "Stadt",
    id: "city",
    type: "text",
    required: true,
    dataTestId: "city-name",
    autocomplete: "on",
  },
  zipCode: {
    label: "PLZ",
    id: "zipCode",
    type: "text",
    required: true,
    dataTestId: "zip-code",
    autocomplete: "on",
  },
  street: {
    label: "Straße",
    id: "street",
    type: "text",
    required: true,
    dataTestId: "street-name",
    autocomplete: "on",
  },
  houseNumber: {
    label: "Hausnummer",
    id: "houseNumber",
    type: "text",
    required: true,
    dataTestId: "house-number",
    autocomplete: "on",
  },
  mobilePhone: {
    label: "Handy Nummer",
    id: "mobilePhone",
    type: "text",
    required: true,
    dataTestId: "mobile-phone",
    autocomplete: "on",
  },
  email: {
    label: "E-Mail",
    id: "email",
    type: "text",
    required: true,
    dataTestId: "e-mail",
    autocomplete: "on",
  },
  gdpr: {
    label: "Ich habe die [link]Datenschutzerklärung[/link] zur Kentniss genommen.",
    id: "gdpr",
    type: "checkbox",
    required: true,
    dataTestId: "gdpr-check",
    link: "https://authentische-momente.de/datenschutz",
  },
  newsLetter: {
    label:
      "Ich möchte den Newsletter erhalten und habe die [link]Datenschutzerklärung[/link] zur Kenntniss genommen.",
    id: "newsletter",
    type: "checkbox",
    required: false,
    dataTestId: "newsletter-check",
    link: "https://authentische-momente.de/datenschutz",
  },
};
