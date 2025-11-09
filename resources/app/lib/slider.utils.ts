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
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
};

const teaserSliderConfig: SwiperOptions = {
  ...defaultConfig,
};

const galleryOneConfig: SwiperOptions = {
  ...defaultConfig,
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
