import { test, expect } from "@playwright/test";
import { fakerDE } from "@faker-js/faker";
import { type Shooting } from "../../resources";
import { FetchApi, type WpPost } from "../../resources/app/utils/fetch.api.wrapper.utils";

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
    title: "Babybauch Shooting",
    productId: "testId",
    participants: { adults: 2, toddlers: 0, childrens: 0, animals: 0 },
  },
};

const API = FetchApi();
const apiUrl = process.env.VITE_API_URL + "/shooting";
const shootingLeadApiUrl = process.env.VITE_SHOOTING_LEAD_API_URL ?? "http://a-m.test/wp-json/am/v2/shooting-lead";

async function getShootingsData() {
  try {
    let response = await API.get<WpPost<Shooting>[]>(`${apiUrl}`);

    if (API.isWpError(response)) return;

    if (response) {
      response.forEach((raw: WpPost<Shooting>) => {
        let { title, product_id } = raw.acf;
        if (title === "Familie") {
          basePayload.booking.title = title;
          basePayload.booking.productId = product_id;
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

test.describe("espo crm Test", () => {
  test("send a request to shooting-lead shootingLeadsApiUrl", async ({ request }) => {
    const payload = {
      customer: basePayload.customer,
      booking: basePayload.booking,
    };

    //payload.customer.newsLetter = true;

    console.log(payload.customer);

    let response = await request.post(shootingLeadApiUrl, {
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
      data: JSON.stringify(payload),
    });

    console.log(await response.text());

    expect(response.ok()).toBe(true);
  });

  test.skip("double e-mail check", async ({ request }) => {
    const payload = {
      customer: basePayload.customer,
      booking: basePayload.booking,
    };

    let responseOne = await request.post(shootingLeadApiUrl, {
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
      data: JSON.stringify(payload),
    });

    console.log(await responseOne.text());

    expect(responseOne.ok()).toBe(true);

    let responseTwo = await request.post(shootingLeadApiUrl, {
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
      data: JSON.stringify(payload),
    });

    console.log(await responseTwo.text());

    expect(responseTwo.ok()).toBe(false);
  });
});
