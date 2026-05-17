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
  class?: string;
  shouldRender?: boolean;
}

export const participantsFormFields: Record<keyof Participants, BookingFormFields> = {
  adults: {
    label: "Erwachsene",
    id: "adults",
    type: "text",
    required: true,
    dataTestId: "adults-test-id",
    autocomplete: "on",
    shouldRender: true,
  },
  childrens: {
    label: "Kinder ab zwei Jahren",
    id: "adults",
    type: "text",
    required: true,
    dataTestId: "children-test-id",
    autocomplete: "on",
    shouldRender: true,
  },
  animals: {
    label: "Haustiere",
    id: "adults",
    type: "text",
    required: true,
    dataTestId: "animals-test-id",
    autocomplete: "on",
    shouldRender: true,
  },
  toddlers: {
    label: "Kinder bis zwei Jahren",
    id: "togglers",
    type: "text",
    required: true,
    dataTestId: "toddlers-test-id",
    autocomplete: "on",
    shouldRender: true,
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
    shouldRender: true,
  },
  lastName: {
    label: "Nachname",
    id: "lastName",
    type: "text",
    required: true,
    dataTestId: "last-name",
    autocomplete: "on",
    shouldRender: true,
  },
  city: {
    label: "Stadt",
    id: "city",
    type: "text",
    required: true,
    dataTestId: "city-name",
    autocomplete: "on",
    shouldRender: true,
  },
  zipCode: {
    label: "PLZ",
    id: "zipCode",
    type: "text",
    required: true,
    dataTestId: "zip-code",
    autocomplete: "on",
    shouldRender: true,
  },
  street: {
    label: "Straße",
    id: "street",
    type: "text",
    required: true,
    dataTestId: "street-name",
    autocomplete: "on",
    shouldRender: true,
  },
  houseNumber: {
    label: "Hausnummer",
    id: "houseNumber",
    type: "text",
    required: true,
    dataTestId: "house-number",
    autocomplete: "on",
    shouldRender: true,
  },
  mobilePhone: {
    label: "Handy Nummer",
    id: "mobilePhone",
    type: "text",
    required: true,
    dataTestId: "mobile-phone",
    autocomplete: "on",
    shouldRender: true,
  },
  email: {
    label: "E-Mail",
    id: "email",
    type: "text",
    required: true,
    dataTestId: "e-mail",
    autocomplete: "on",
    shouldRender: true,
  },
  gdpr: {
    label: "Ich habe die [link]Datenschutzerklärung[/link] zur Kentniss genommen.",
    id: "gdpr",
    type: "checkbox",
    required: true,
    dataTestId: "gdpr-check",
    link: "https://authentische-momente.de/datenschutz",
    shouldRender: true,
  },
  newsLetter: {
    label:
      "Ich möchte den Newsletter erhalten und habe die [link]Datenschutzerklärung[/link] zur Kenntniss genommen.",
    id: "newsletter",
    type: "checkbox",
    required: false,
    dataTestId: "newsletter-check",
    link: "https://authentische-momente.de/datenschutz",
    shouldRender: true,
  },
  honeyPot: {
    label: "Website Traffic Numbers",
    id: "web-traffic-nm",
    dataTestId: "web-traffic-test",
    type: "text",
    required: false,
    class: "hp-field",
    shouldRender: false,
  },
};
