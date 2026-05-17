import { test, expect, Page } from "@playwright/test";
import { fakerDE } from "@faker-js/faker";
import { type Shooting, type Booking } from "../../resources";
import { type Customer } from "./../../resources/lib/validation/schemas/customer.schema";
import { customerFormFields } from "../../resources/app/components/booking-shooting/booking.form.shape";
import { FetchApi, type WpPost } from "../../resources/app/utils/fetch.api.wrapper.utils";
import { env } from "./config/env";

const testCustomer: Customer = {
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
};

const booking: Booking = {
  title: "",
  productId: "",
  variant: { title: "", benefits: "" },
  participants: { adults: 2, toddlers: 0, childrens: 0, animals: 0 },
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
          booking.title = title;
          booking.productId = product_id;
          booking.variant.title = variants["variant_2"].title;
          booking.variant.benefits = variants["variant_2"].benefits;
        }
      });
    }
  } catch (e) {
    API.handleNetworkError(e);
  }
}

test("send a request to shooting-lead endpoint", async ({ request }) => {
  await getShootingsData();
  const payload = JSON.stringify({
    customer: testCustomer,
    booking: booking,
  });
  let response = await request.post(shootingLeadsApiUrl, {
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
    },
    data: payload,
  });
  console.log(response);
});
