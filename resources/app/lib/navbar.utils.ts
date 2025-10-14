/**
 * Navigation bar management module
 * Handles toggle functionality for navbar and shootings dropdown
 */

const navbar = document.querySelector<HTMLElement>("#navbar-right");
const navbarToggle = navbar?.querySelector<HTMLDivElement>("#navbar-toggle");
const navbarLinks = navbar?.querySelector<HTMLUListElement>("#navigation-links");
const shootingsToggle = navbar?.querySelector<HTMLButtonElement>("#shootings-toggle");
const shootingLinks = navbar?.querySelector<HTMLUListElement>("#shooting-links");
const shootingToggleIcon = navbar?.querySelector<SVGElement>("#shootings-toggle-icon");
navbarToggle?.addEventListener("click", toggleNavbar);

/**
 * Toggles a data attribute on an HTML element between "true" and "false"
 *
 * @param element - The HTML element to toggle the attrubute on
 * @param attribute - The data attribute name to toggle (default: "isToggled")
 */

function toggleDataAttribute(
  element: HTMLElement | null | undefined,
  attribute: string = "isToggled"
) {
  if (!element) {
    console.warn("Element not found for toggle operation");
    return;
  }
  if (element === navbarLinks && shootingLinks?.dataset[attribute] === "true") {
    toggleShootings();
  } else if (element === shootingLinks && navbarLinks?.dataset[attribute] === "true") {
    toggleNavbar();
  }
  const currentValue = element.dataset[attribute];
  element.dataset[attribute] = currentValue === "true" ? "false" : "true";
}

function toggleShootings() {
  toggleDataAttribute(shootingLinks);
  shootingToggleIcon?.classList.toggle("rotate-180");
  shootingsToggle?.classList.toggle("bg-blue/50");
}

function transforToggleMenu() {
  if (navbarToggle) {
    toggleDataAttribute(navbarToggle);
    navbarToggle.children[0].classList.toggle("first-div");
    navbarToggle.children[1].classList.toggle("second-div");
    navbarToggle.children[2].classList.toggle("third-div");
  }
}

function toggleNavbar() {
  toggleDataAttribute(navbarLinks);
  transforToggleMenu();
}
