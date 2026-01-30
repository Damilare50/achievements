export interface User {
  id: string;
  name: string;
  email: string;
  no_of_purchases?: number;
}

export interface SignupData {
  name: string;
  email: string;
  password: string;
}

export interface LoginData {
  email: string;
  password: string;
}

export interface AuthResponse {
  access_token?: string;
  user?: User;
  message?: string;
  errors?: string;
}
