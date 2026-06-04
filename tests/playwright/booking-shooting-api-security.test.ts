import { test, expect } from "@playwright/test";
import { fakerDE } from "@faker-js/faker";
import { type Shooting, type Booking } from "../../resources";
import { FetchApi, type WpPost } from "../../resources/app/utils/fetch.api.wrapper.utils";
import { randomAttack } from "./utils/attack-generator";

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

test.describe("security fuzzing", () => {
  test.skip("rejects xss payload on customer fields", async ({ request }) => {
    const payload = structuredClone(basePayload);

    for (let key in payload.customer) {
      payload.customer[key] = randomAttack("xss");

      const response = await request.post(shootingLeadsApiUrl, {
        data: payload,
      });

      expect(response.status()).toBe(400);
      expect(response.ok()).toBe(false);
    }
  });

  test.skip("rejects xss payload on booking fields", async ({ request }) => {
    const payload = structuredClone(basePayload);

    for (let key in payload.booking) {
      payload.booking[key] = randomAttack("xss");

      const response = await request.post(shootingLeadsApiUrl, {
        data: payload,
      });

      expect(response.status()).toBe(400);
      expect(response.ok()).toBe(false);
    }
  });

  test.skip("rejects sql payload on customer fields", async ({ request }) => {
    const payload = structuredClone(basePayload);

    for (let key in payload.customer) {
      payload.customer[key] = randomAttack("sql");

      const response = await request.post(shootingLeadsApiUrl, {
        data: payload,
      });

      expect(response.status()).toBe(400);
      expect(response.ok()).toBe(false);
    }
  });
  test.skip("rejects sql payload on booking fields", async ({ request }) => {
    const payload = structuredClone(basePayload);

    for (let key in payload.booking) {
      payload.booking[key] = randomAttack("sql");

      const response = await request.post(shootingLeadsApiUrl, {
        data: payload,
      });

      expect(response.status()).toBe(400);
      expect(response.ok()).toBe(false);
    }
  });

  test.skip("rejects html payload on customer fields", async ({ request }) => {
    const payload = structuredClone(basePayload);

    for (let key in payload.customer) {
      payload.customer[key] = randomAttack("htmlInjection");

      const response = await request.post(shootingLeadsApiUrl, {
        data: payload,
      });

      expect(response.status()).toBe(400);
      expect(response.ok()).toBe(false);
    }
  });
  test.skip("rejects html payload on booking fields", async ({ request }) => {
    const payload = structuredClone(basePayload);

    for (let key in payload.booking) {
      payload.booking[key] = randomAttack("htmlInjection");

      const response = await request.post(shootingLeadsApiUrl, {
        data: payload,
      });

      expect(response.status()).toBe(400);
      expect(response.ok()).toBe(false);
    }
  });
  test.skip("rejects malformed payload on customer fields", async ({ request }) => {
    const payload = structuredClone(basePayload);

    for (let key in payload.customer) {
      payload.customer[key] = randomAttack("malformed");

      const response = await request.post(shootingLeadsApiUrl, {
        data: payload,
      });

      expect(response.status()).toBe(400);
      expect(response.ok()).toBe(false);
    }
  });
  test.skip("rejects malformed payload on booking fields", async ({ request }) => {
    const payload = structuredClone(basePayload);

    for (let key in payload.booking) {
      payload.booking[key] = randomAttack("malformed");

      const response = await request.post(shootingLeadsApiUrl, {
        data: payload,
      });

      expect(response.status()).toBe(400);
      expect(response.ok()).toBe(false);
    }
  });
  test.skip("rejects mixed chaos payload on customer fields", async ({ request }) => {
    const payload = structuredClone(basePayload);

    for (let key in payload.customer) {
      payload.customer[key] = randomAttack("mixedChaos");

      const response = await request.post(shootingLeadsApiUrl, {
        data: payload,
      });

      console.log(response);
      expect(response.status()).toBe(400);
      expect(response.ok()).toBe(false);
    }
  });
  test.skip("rejects mixedchaos payload on booking fields", async ({ request }) => {
    const payload = structuredClone(basePayload);

    for (let key in payload.booking) {
      payload.booking[key] = randomAttack("mixedChaos");

      const response = await request.post(shootingLeadsApiUrl, {
        data: payload,
      });

      expect(response.status()).toBe(400);
      expect(response.ok()).toBe(false);
    }
  });
  test.skip("rejects mixed chaos payload on participant fields", async ({ request }) => {
    const payload = structuredClone(basePayload);

    for (let key in payload.booking.participants) {
      payload.booking.participants[key] = randomAttack("mixedChaos");

      const response = await request.post(shootingLeadsApiUrl, {
        data: payload,
      });

      console.log(response);
      expect(response.status()).toBe(400);
      expect(response.ok()).toBe(false);
    }
  });
  test("rejects mixed chaos payload on vairant fields", async ({ request }) => {
    const payload = structuredClone(basePayload);

    for (let key in payload.booking.variant) {
      payload.booking.variant[key] = randomAttack("mixedChaos");

      const response = await request.post(shootingLeadsApiUrl, {
        data: payload,
      });

      console.log(response);
      expect(response.status()).toBe(400);
      expect(response.ok()).toBe(false);
    }
  });
});
