import axios from "axios";
import {
  AuthResponse,
  GetUserAchievementsResponse,
  LoginData,
  SignupData,
  User,
} from "../types/auth";

const API_BASE_URL = "http://localhost:8000/api";

const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    "Content-Type": "application/json",
  },
});

export const authAPI = {
  signup: async (data: SignupData) => {
    const response = await api.post<AuthResponse>("/create", data);

    return response;
  },

  login: async (data: LoginData) => {
    const response = await api.post<AuthResponse>("/login", data);

    return response;
  },

  logout: async (token: string) => {
    const response = await api.post(
      "/logout",
      {},
      {
        headers: { Authorization: `Bearer ${token}` },
      },
    );

    return response;
  },

  getUser: async (token: string) => {
    const response = await api.get<User>("/user", {
      headers: { Authorization: `Bearer ${token}` },
    });

    return response;
  },

  getUserAchievements: async (userId: string, token: string) => {
    const response = await api.get<GetUserAchievementsResponse>(
      `/user/${userId}/achievements`,
      {
        headers: { Authorization: `Bearer ${token}` },
      },
    );

    return response;
  },
};
