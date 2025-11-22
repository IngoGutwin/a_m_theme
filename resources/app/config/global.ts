interface GlobalVariables {
  shootingBookingUrl: string;
}

let _globals: GlobalVariables | null = null;

export function loadGlobalVariables(): GlobalVariables | null {
  if (_globals) {
    return _globals;
  }

  let app = document.querySelector<HTMLElement>("#app");
  if (!app) {
    return null;
  }

  let data = app.dataset.globalVariables;
  if (!data) {
    return null;
  }
  delete app.dataset.globalVariables;

  try {
    _globals = JSON.parse(data) as GlobalVariables;
    return _globals;
  } catch (error) {
    console.error(error);
    return null;
  }
}
