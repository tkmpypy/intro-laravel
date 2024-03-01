export class APIClient {
  baseURL: string;

  constructor(baseURL: string) {
    this.baseURL = baseURL;
  }

  async request(path: string, method: string, data?: object) {
    const url = new URL(`${this.baseURL}${path}`);
    let req: any = {
      method: method,
      headers: {
        "Content-TYpe": "application/json",
      },
    };
    if (data !== undefined) {
      req.body = JSON.stringify(data);
    }

    return await fetch(url, req);
  }

  async post(path: string, data: object) {
    return await this.request(path, "POST", data);
  }

  async delete(path: string) {
    return await this.request(path, "DELETE");
  }

  async patch(path: string, data: object) {
    return await this.request(path, "PATCH", data);
  }
}
