const navbar = document.querySelector("#navbar") as HTMLElement;
const navbar_toggle = navbar.querySelector("#navbar-toggle") as HTMLDivElement;
const navbar_links = navbar.querySelector("#navbar-links") as HTMLUListElement;
const shootings_btn_nav = navbar.querySelector('#shootings-btn-nav') as HTMLButtonElement;

function toggle_navbar(): void {
  let is_toggled = navbar_links.dataset.isToggled;
  if (is_toggled === "false") {
    navbar_links.dataset.isToggled = "true";
  } else {
    navbar_links.dataset.isToggled = "false";
  }
}

function toggle_shootings(): void {
  let is_toggled = shootings_btn_nav.dataset.isToggled;
  if (is_toggled === "false") {
    shootings_btn_nav.dataset.isToggled = "true";
  } else {
    shootings_btn_nav.dataset.isToggled = "false";
  }
}

navbar_toggle?.addEventListener("click", toggle_navbar);
shootings_btn_nav?.addEventListener("click", toggle_shootings);
