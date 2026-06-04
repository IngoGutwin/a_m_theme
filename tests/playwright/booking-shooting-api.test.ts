import { test, expect } from "@playwright/test";
import { fakerDE } from "@faker-js/faker";
import { type Shooting, type Booking } from "../../resources";
import { type Customer } from "./../../resources/lib/validation/schemas/customer.schema";
import { customerFormFields } from "../../resources/app/components/booking-shooting/booking.form.shape";
import { FetchApi, type WpPost } from "../../resources/app/utils/fetch.api.wrapper.utils";
import { randomAttack, generateAttackSet } from "./utils/attack-generator";

const basePayload = {
  customer: {
    firstName: fakerDE.person.firstName(),
    lastName: fakerDE.person.lastName(),
    email: fakerDE.internet.email(),
    mobilePhone: fakerDE.phone.number({ style: "human" }),
    street: fakerDE.location.street(),
    houseNumber: fakerDE.location.buildingNumber(),
    zipCode: fakerDE.location.zipCode(),
    city: fakerDE.location.city(),
    gdpr: true,
    newsLetter: false,
    honeyPot: "",
  },
  booking: {
    title: "",
    productId: "",
    variant: { title: "", benefits: "" },
    participants: { adults: 2, toddlers: 0, childrens: 0, animals: 0 },
  },
};

const API = FetchApi();
const apiUrl = process.env.VITE_API_URL + "/shooting";
const shootingLeadsApiUrl = process.env.VITE_SHOOTING_LEAD_POST_API_URL ?? "";

async function getShootingsData() {
  try {
    let response = await API.get<WpPost<Shooting>[]>(`${apiUrl}`);

    if (API.isWpError(response)) return;

    if (response) {
      response.forEach((raw: WpPost<Shooting>) => {
        let { title, product_id, variants } = raw.acf;
        if (title === "Familie") {
          basePayload.booking.title = title;
          basePayload.booking.productId = product_id;
          basePayload.booking.variant.title = variants["variant_2"].title;
          basePayload.booking.variant.benefits = variants["variant_2"].benefits;
        }
      });
    }
  } catch (e) {
    API.handleNetworkError(e);
  }
}

test.beforeEach(async () => {
  await getShootingsData();
});

test.describe("clean data Test", () => {
  test("send a request to shooting-lead shootingLeadsApiUrl", async ({ request }) => {
    const payload = {
      customer: basePayload.customer,
      booking: basePayload.booking,
    };

    console.log(payload.customer);
    console.log(payload.booking);

    let response = await request.post(shootingLeadsApiUrl, {
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
      data: JSON.stringify(payload),
    });

    console.log(response);

    expect(response.ok()).toBe(true);
  });

  test.skip("send a request to shooting-lead shootingLeadsApiUrl, with false gdpr", async ({
    request,
  }) => {
    basePayload.customer.gdpr = false;
    const payload = JSON.stringify({
      customer: basePayload.customer,
      booking: basePayload.booking,
    });
    let response = await request.post(shootingLeadsApiUrl, {
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
      data: payload,
    });
    expect(response.status()).toBe(400);
    expect(response.ok()).toBe(false);
  });

});
