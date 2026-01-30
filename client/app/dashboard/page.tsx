"use client";

import { useEffect, useState } from "react";
import { useRouter } from "next/navigation";
import { User } from "@/lib/types/auth";
import { authAPI } from "@/lib/api/auth";

export default function DashboardPage() {
  const router = useRouter();
  const [user, setUser] = useState<User | null>(null);

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (!token) {
      router.push("/login");
      return;
    }

    async function fetchUserData(token: string) {
      const response = await authAPI.getUser(token);

      if (response.status === 200 && response.data) {
        setUser(response.data);
        return;
      }

      router.push("/login");
      return;
    }
    fetchUserData(token);
  }, [router]);

  const handleLogout = () => {
    const token = localStorage.getItem("token");

    if (token) {
      authAPI.logout(token);
    }
    localStorage.removeItem("token");
    router.push("/login");
  };

  return (
    <div className="min-h-screen bg-gray-50 p-8">
      <div className="max-w-4xl mx-auto">
        <div className="flex justify-between items-center mb-8">
          <h1 className="text-3xl font-bold text-gray-900">Dashboard</h1>
          <button
            onClick={handleLogout}
            className="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
          >
            Logout
          </button>
        </div>

        <div className="bg-white rounded-lg shadow p-6">
          <h2 className="text-xl font-bold mb-4">Welcome back!</h2>
          <p className="text-gray-600">
            You&apos;re logged in as:{" "}
            <span className="font-medium">{user?.email}</span>
          </p>
          <div className="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div className="p-4 bg-blue-50 rounded-lg">
              <h3 className="font-medium text-blue-900">Quick Stats</h3>
              <p className="text-2xl font-bold text-blue-600 mt-2">0</p>
            </div>
            {/* Add more dashboard widgets here */}
          </div>
        </div>
      </div>
    </div>
  );
}
