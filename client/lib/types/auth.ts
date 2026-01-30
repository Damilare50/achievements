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

export interface GetUserAchievementsResponse {
  unlocked_achievements: string[];
  next_available_achievements: string[];
  current_badge: string;
  next_badge: string;
  remaining_to_unlock_next_badge: number;
}
