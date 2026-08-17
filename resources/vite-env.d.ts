/// <reference types="vite/client" />

declare module "swiper/css" {}
declare module "swiper/css/navigation" {}

interface ImportMetaEnv {
  readonly VITE_API_URL: string;
  readonly VITE_SHOOTING_LEAD_API_URL: string;
}

interface ImportMeta {
  readonly env: ImportMetaEnv;
}
