"use client";

import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { signupSchema, SignupFormData } from "@/lib/utils/validation";
import Input from "@/component/element/Input";
import Button from "@/component/element/Button";
import { authAPI } from "@/lib/api/auth";
import { useRouter } from "next/navigation";
import { useEffect, useState } from "react";
import { AxiosError } from "axios";

export default function SignupForm() {
  const router = useRouter();
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (token) {
      router.push("/dashboard");
    }
  }, [router]);

  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm<SignupFormData>({
    resolver: zodResolver(signupSchema),
  });

  const onSubmit = async (data: SignupFormData) => {
    try {
      setLoading(true);
      setError("");
      const response = await authAPI.signup(data);

      if (response.status === 200 && response.data.access_token) {
        // Store token in localStorage or cookies
        localStorage.setItem("token", response.data.access_token);

        router.push("/dashboard");
      } else {
        setError(
          response.data.message || "An error occurred. Please try again.",
        );
      }
    } catch (err: unknown) {
      if (err instanceof AxiosError && err.response) {
        setError(err.response.data?.message || "Signup failed");
        return;
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)} className="space-y-4">
      {error && (
        <div className="p-3 bg-red-100 text-red-700 rounded-md">{error}</div>
      )}

      <Input
        label="Full Name"
        type="text"
        {...register("name")}
        error={errors.name?.message}
      />

      <Input
        label="Email Address"
        type="email"
        {...register("email")}
        error={errors.email?.message}
      />

      <Input
        label="Password"
        type="password"
        {...register("password")}
        error={errors.password?.message}
      />

      <Button type="submit" loading={loading} className="w-full">
        Sign Up
      </Button>

      <p className="text-center text-sm text-gray-600">
        Already have an account?{" "}
        <a href="/login" className="text-blue-600 hover:underline">
          Log in
        </a>
      </p>
    </form>
  );
}
