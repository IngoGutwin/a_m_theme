interface GlobalVariables {
  contactPageUrl: string;
  time: number;
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

  try {
    _globals = JSON.parse(data) as GlobalVariables;
    _globals.time = Date.now();
    return _globals;
  } catch (error) {
    console.error(error);
    return null;
  }
}
