export function FetchApi() {
  async function get<T>(url: string): Promise<T | undefined> {
    try {
      let response = await fetch(url);
      if (!response.ok) {
        throw new Error(`Response status: ${response.status}`);
      }
      return await response.json();
    } catch (e: unknown) {
      if (e instanceof Error) {
        console.error(e.message);
      } else {
        console.error("Unknown Error: ", e);
        throw e;
      }
    }
  }

  return {
    get,
  };
}
