/**
 * Navigation bar management module
 * Handles toggle functionality for navbar and shootings dropdown
 */

export function initNavBar() {
  let navbar = document.querySelector<HTMLElement>("#navbar-right");
  if (!navbar) {
    return null;
  }

  let navbarToggle = navbar.querySelector<HTMLDivElement>("#navbar-toggle");
  let navbarLinks = navbar?.querySelector<HTMLUListElement>("#navigation-links");
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
    let currentValue = element.dataset[attribute];
    element.dataset[attribute] = currentValue === "true" ? "false" : "true";
}

  function transformToggleMenu() {
    if (navbarToggle) {
      toggleDataAttribute(navbarToggle);
      navbarToggle.children[0].classList.toggle("first-div");
      navbarToggle.children[1].classList.toggle("second-div");
      navbarToggle.children[2].classList.toggle("third-div");
    }
  }

  function toggleNavbar() {
    toggleDataAttribute(navbarLinks);
    transformToggleMenu();
  }
}

