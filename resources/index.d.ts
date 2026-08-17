export interface Shooting {
  title: string;
  product_id: string;
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
  participants: Participants;
}

export type ValidationErrors<T> = Partial<Record<keyof T, string>>;

export type TouchedFields<T> = Partial<Record<keyof T, boolean>>;
