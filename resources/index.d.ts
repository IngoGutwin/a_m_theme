declare module "swiper/css" {}
declare module "swiper/css/navigation" {}

declare module "*.vue" {
  import type { DefineComponent } from "vue";
  const component: DefineComponent<object, object, unknown>;
  export default component;
}

interface ShootingVariant {
  title: string;
  benefits: string;
}

export interface Shooting {
  title: string;
  product_id: string;
  variants: Record<string, ShootingVariant>;
}

export interface Participants {
  adults: number;
  childrens: number;
  toddlers: number;
  animals: number;
}

export interface Booking {
  title: string;
  productId: string;
  variant: ShootingVariant;
  participants: Participants;
}

export type ValidationErrors<T> = Partial<Record<keyof T, string>>;

export type TouchedFields<T> = Partial<Record<keyof T, boolean>>;
