interface GlobalVariables {
  someGlobalVar: string;
}

export const globals: GlobalVariables | null = loadGlobalVariables();

function loadGlobalVariables(): GlobalVariables | null {
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
    return JSON.parse(data) as GlobalVariables;
  } catch (error) {
    console.error(error);
    return null;
  }
}
