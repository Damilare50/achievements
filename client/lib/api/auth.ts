import axios from "axios";

const API_BASE_URL = "http://localhost:8000/api";

const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    "Content-Type": "application/json",
  },
});

export const authAPI = {
  signup: async (data: { name: string; email: string; password: string }) => {
    const response = await api.post("/create", data);

    return response.data;
  },

  login: async (data: { email: string; password: string }) => {
    const response = await api.post("/login", data);

    return response.data;
  },

  logout: async (token: string) => {
    const response = await api.post(
      "/logout",
      {},
      {
        headers: { Authorization: `Bearer ${token}` },
      },
    );

    return response.data;
  },
};
