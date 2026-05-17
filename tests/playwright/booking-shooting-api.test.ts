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
  test.skip("send a request to shooting-lead shootingLeadsApiUrl", async ({ request }) => {
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

test.describe("security fuzzing", () => {
  test("rejects xss payload", async ({ request }) => {
    const payload = structuredClone(basePayload);

    payload.customer.firstName = randomAttack("xss");

    const response = await request.post(shootingLeadsApiUrl, {
      data: payload,
    });

    expect(response.status()).toBeLessThan(500);
  });

  test("rejects sql injection payload", async ({ request }) => {
    const payload = structuredClone(basePayload);

    payload.customer.lastName = randomAttack("sql");

    const response = await request.post(shootingLeadsApiUrl, {
      data: payload,
    });

    expect(response.status()).toBeLessThan(500);
  });

  test("rejects html injection payload", async ({ request }) => {
    const payload = structuredClone(basePayload);

    payload.customer.city = randomAttack("htmlInjection");

    const response = await request.post(shootingLeadsApiUrl, {
      data: payload,
    });

    expect(response.status()).toBeLessThan(500);
  });

  test("rejects overflow payload", async ({ request }) => {
    const payload = structuredClone(basePayload);

    payload.customer.firstName = randomAttack("overflow");

    const response = await request.post(shootingLeadsApiUrl, {
      data: payload,
    });

    expect(response.status()).toBeLessThan(500);
  });

  test("rejects unicode payload", async ({ request }) => {
    const payload = structuredClone(basePayload);

    payload.customer.firstName = randomAttack("unicode");

    const response = await request.post(shootingLeadsApiUrl, {
      data: payload,
    });

    expect(response.status()).toBeLessThan(500);
  });

  test("rejects malformed payload", async ({ request }) => {
    const payload = structuredClone(basePayload);

    payload.customer.email = randomAttack("malformed");

    const response = await request.post(shootingLeadsApiUrl, {
      data: payload,
    });

    expect(response.status()).toBeLessThan(500);
  });

  test("rejects mixed chaos payload", async ({ request }) => {
    const payload = structuredClone(basePayload);

    const attacks = generateAttackSet();

    payload.customer.firstName = attacks.xss;
    payload.customer.lastName = attacks.sql;
    payload.customer.city = attacks.unicode;

    payload.customer.email = attacks.malformed;

    const response = await request.post(shootingLeadsApiUrl, {
      data: payload,
    });

    expect(response.status()).toBeLessThan(500);
  });

  test("test numbers on strings", async ({ request }) => {
    const payload = structuredClone(basePayload);

    const attacks = generateAttackSet();

    payload.customer.firstName = 2323232;
    payload.customer.lastName = 232323;
    payload.customer.city = 232323;

    const response = await request.post(shootingLeadsApiUrl, {
      data: payload,
    });

    console.log("status: ", response.status());
    console.log("message: ", response.statusText());
    expect(response.status()).toBeLessThan(500);
  });
});
