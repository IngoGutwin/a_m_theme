// -----------------------------
// API Response Types
// -----------------------------

/**
 * Raw Wordpress REST API Response shape
 */
export interface WpPost<TAcf> {
  id: number;
  slug: string;
  status: string;
  type: string;
  link: string;
  title: { rendered: string };
  acf: TAcf;
}

/**
 * Shape of a Wordpress Error Response.
 */

interface WpError {
  code: string;
  message: string;
  data: {
    status: number;
    retry_after: number;
  };
}

/**
 * Every fetch result is either a the expected data T, or a WpError.
 * The caller can use isWpError() to narrow the type
 */
type ApiResult<T> = T | WpError;

// -----------------------------
// Request options
// -----------------------------

/*
 * POST Request Options
 * @template B Shape of the request body (types not just 'any')
 *
 */
interface PostOptions<B> {
  url: string;
  body: B;
  headers?: Record<string, string>;
}

// -----------------------------
// Fetch Wrapper
// -----------------------------
/**
 * Fetch API Wrapper
 */
export function FetchApi() {
  // -----------------------------
  // Shared default Headers
  // -----------------------------
  const defaultHeaders: Record<string, string> = {
    "Content-Type": "application/json",
    Accept: "application/json",
  };

  // -----------------------------
  // Shared error handler
  // -----------------------------
  /**
   * Handles errors thrown by fetch() itself (not HTTP error responses).
   * fetch() only throws on network failures, not on 4xx/5xx responses.
   */
  function handleNetworkError(e: unknown): void {
    if (e instanceof Error) {
      console.error("[FetchApi] Network error:", e.message);
    } else {
      console.error("[FetchApi] Unknown error:", e);
    }
  }

  // -----------------------------
  // Type Guard
  // -----------------------------

  /**
   * Narrows an ApiResult to WpError so the caller can handle errors explicitly.
   */
  function isWpError(value: unknown): value is WpError {
    return (
      typeof value === "object" &&
      value !== null &&
      "code" in value &&
      "message" in value &&
      "data" in value
    );
  }

  // -----------------------------
  // GET
  // -----------------------------
  /**
   * Sends Get Requests and returns the parsed JSON body typed as T.
   * Returns a WpError object (does NOT thorw) when the server responds with
   * a non-2xx status, so the caller always gets a value to work with.
   *
   * @param url Full URL including any query parameters.
   */
  async function get<T>(url: string): Promise<ApiResult<T> | undefined> {
    let response = await fetch(url, {
      method: "GET",
      headers: defaultHeaders,
    });
    let data = await response.json();

    if (!response.ok) {
      return data as WpError;
    }

    return data as T;
  }

  // -----------------------------
  // POST
  // -----------------------------
  /**
   * Sends POST Requests and returns the parsed JSON body typed as T.
   *
   * Handles all WordPress REST API status codes:
   * 201 Created          → returns typed response T
   * 400 Bad Request      → returns WpError (missing / invalid fields)
   * 403 Forbidden        → returns WpError (origin blocked)
   * 409 Conflict         → returns WpError (duplicate e-mail)
   * 422 Unprocessable    → returns WpError (GDPR not given)
   * 429 Too Many Reqs    → returns WpError with retry_after seconds
   * 500 Server Error     → returns WpError
   *
   * @param options  { url, body, headers? }
   */
  async function post<T, B = Record<string, unknown>>(
    options: PostOptions<B>
  ): Promise<ApiResult<T> | undefined> {
    const { url, body, headers = {} } = options;

    const response = await fetch(url, {
      method: "POST",
      headers: { ...defaultHeaders, ...headers },
      body: JSON.stringify(body),
    });

    const data = await response.json();

    if (!response.ok) {
      // Log 429 retry hint to the console so devs can see it during testing
      if (response.status === 429 && isWpError(data) && data.data.retry_after) {
        console.warn(`[FetchApi] Rate limited. Retry after ${data.data.retry_after}s.`);
      }
      return data as WpError;
    }

    return data as T;
  }

  return {
    get,
    post,
    isWpError,
    handleNetworkError,
  };
}
