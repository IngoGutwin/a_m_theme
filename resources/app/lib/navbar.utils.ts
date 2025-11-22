/**
 * Navigation bar management module
 * Handles toggle functionality for navbar and shootings dropdown
 */

export function initNavBar() {
  let navbar = document.querySelector<HTMLElement>("#navbar-right");
  if (!navbar) {
    return null;
  }

  let hamburgerContainer = navbar.querySelector<HTMLDivElement>("#hamburger-container");
  let hamburgerMenu = navbar.querySelector<HTMLDivElement>("#hamburger-menu");
  let navbarLinks = navbar?.querySelector<HTMLUListElement>("#navigation-links");
  hamburgerContainer?.addEventListener("click", toggleHamburgerMenu);
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
    if (hamburgerMenu) {
      toggleDataAttribute(hamburgerContainer);
      hamburgerMenu.children[0].classList.toggle("first-div");
      hamburgerMenu.children[1].classList.toggle("second-div");
      hamburgerMenu.children[2].classList.toggle("third-div");
    }
  }

  function toggleHamburgerMenu() {
    toggleDataAttribute(navbarLinks);
    transformToggleMenu();
  }
}

