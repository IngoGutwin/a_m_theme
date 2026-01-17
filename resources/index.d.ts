declare module "swiper/css" {}
declare module "swiper/css/navigation" {}

declare module "*.vue" {
  import type { DefineComponent } from "vue";
  const component: DefineComponent<object, object, unknown>;
  export default component;
}

export interface Shooting {
  title: string;
  product_id: string;
  variants: object;
}

export interface Customer {
  firstName: string;
  lastName: string;
  gdpr: boolean;
}

export interface CustomerProduct {
  title: string;
  productId: string;
  variant: object;
}

export interface CustomerAppoinment {
  shooting: CustomerProduct;
  customer: Customer;
}
