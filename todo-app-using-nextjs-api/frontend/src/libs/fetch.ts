import { getAPIBaseURL } from "@/libs/utils";

export default async function fetcher<JSON = any>(
  input: RequestInfo,
  init?: RequestInit,
): Promise<JSON> {
  const base = getAPIBaseURL();
  const res = await fetch(`${base}${input}`, init);
  return res.json();
}
