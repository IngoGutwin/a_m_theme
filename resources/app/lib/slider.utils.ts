import Swiper from "swiper";
import type { SwiperOptions } from "swiper/types";
import { Navigation } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";

const defaultConfig: SwiperOptions = {
  direction: "horizontal",
  modules: [Navigation],
  allowTouchMove: true,
  grabCursor: true,
  slidesPerView: "auto",
};

const teaserSliderConfig: SwiperOptions = {
  ...defaultConfig,
  navigation: {
    nextEl: ".teaser-section .swiper-button-next",
    prevEl: ".teaser-section .swiper-button-prev",
  },
};

const galleryOneConfig: SwiperOptions = {
  ...defaultConfig,
  centeredSlides: true,
  navigation: {
    nextEl: ".gallery-section .swiper-button-next",
    prevEl: ".gallery-section .swiper-button-prev",
  },
};

export function initSwiper() {
  let sliderSections = document.querySelectorAll<HTMLElement>(".swiper");
  sliderSections.forEach((section) => {
    let swiperClass = section.classList[1];
    switch (swiperClass) {
      case "gallery-section":
        new Swiper(section, galleryOneConfig);
        break;
      case "teaser-section":
        new Swiper(section, teaserSliderConfig);
        break;
    }
  });
}
