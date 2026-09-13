import type { SwiperOptions } from "swiper/types";

async function loadSwiper(sliderSections: NodeListOf<HTMLElement>) {
  const { default: Swiper } = await import("swiper");
  const { Navigation } = await import("swiper/modules");
  await import("swiper/css");
  await import("swiper/css/navigation");

  let defaultConfig: SwiperOptions = {
    direction: "horizontal",
    modules: [Navigation],
    allowTouchMove: true,
    grabCursor: true,
    slidesPerView: "auto",
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  };

  sliderSections.forEach((section) => {
    let swiperClass = section.classList[1];
    switch (swiperClass) {
      case "gallery-section":
        new Swiper(section, defaultConfig);
        break;
      case "teaser-section":
        new Swiper(section, defaultConfig);
        break;
    }
  });
}

export function initSwiper() {
  let sliderSections = document.querySelectorAll<HTMLElement>(".swiper");
  if (sliderSections.length > 0) {
    loadSwiper(sliderSections);
  }
}
