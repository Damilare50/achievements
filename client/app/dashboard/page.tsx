"use client";

import { useEffect, useState } from "react";
import { useRouter } from "next/navigation";
import { GetUserAchievementsResponse, User } from "@/lib/types/index";
import { serverAPI } from "@/lib/api";
import { AxiosError } from "axios";

export default function DashboardPage() {
  const router = useRouter();
  const [user, setUser] = useState<User | null>(null);
  const [achievementData, setAchievementData] =
    useState<GetUserAchievementsResponse | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (!token) {
      router.push("/login");
      return;
    }

    try {
      async function fetchUserData(token: string) {
        const response = await serverAPI.getUser(token);

        if (response.status === 200 && response.data) {
          setUser(() => response.data);
        }

        const data = await serverAPI.getUserAchievements(
          response.data.id,
          token,
        );

        if (data.status === 200 && data.data) {
          setAchievementData(() => data.data);
          setLoading(false);
          return;
        }

        router.push("/login");
        return;
      }

      fetchUserData(token);
    } catch (err: unknown) {
      if (err instanceof AxiosError) {
        if (err.response?.status === 401) {
          localStorage.removeItem("token");
        }

        router.push("/login");
      }
    }
  }, [router]);

  const handleLogout = () => {
    const token = localStorage.getItem("token");

    if (token) {
      serverAPI.logout(token);
    }
    localStorage.removeItem("token");
    router.push("/login");
  };

  return (
    <>
      {loading ? (
        <div className="min-h-screen bg-gray-50 p-8">
          <div className="max-w-4xl mx-auto">
            <div className="flex justify-center items-center h-64">
              <div className="text-center">
                <div className="w-8 h-8 border-2 border-blue-500 border-t-transparent rounded-full animate-spin mx-auto"></div>
                <p className="mt-2 text-gray-600">Loading...</p>
              </div>
            </div>
          </div>
        </div>
      ) : (
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

            {/* Welcome Section */}
            <div className="bg-white rounded-lg shadow p-6 mb-6">
              <h2 className="text-xl font-bold mb-2">Welcome back!</h2>
              <p className="text-gray-600">
                You&apos;re logged in as:{" "}
                <span className="font-medium">{user?.email}</span>
              </p>
            </div>

            {/* Achievements Section */}
            {achievementData && (
              <>
                {/* Badge Display */}
                <div className="bg-white rounded-lg shadow p-6 mb-6">
                  <h2 className="text-lg font-semibold text-gray-800 mb-4">
                    Your Badges
                  </h2>
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div className="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                      <h3 className="font-medium text-yellow-800 mb-2">
                        Current Badge
                      </h3>
                      <p className="text-2xl font-bold text-yellow-600">
                        {achievementData.current_badge.length != 0
                          ? achievementData.current_badge
                          : "No badges unlocked...yet"}
                      </p>
                    </div>
                    <div className="p-4 bg-blue-50 rounded-lg border border-blue-200">
                      <h3 className="font-medium text-blue-800 mb-2">
                        Next Badge
                      </h3>
                      <p className="text-2xl font-bold text-blue-600">
                        {achievementData.next_badge}
                      </p>
                      <p className="text-sm text-blue-600 mt-1">
                        {achievementData.remaining_to_unlock_next_badge} more
                        purchases needed
                      </p>
                    </div>
                  </div>
                </div>

                {/* Progress Bar */}
                <div className="bg-white rounded-lg shadow p-6 mb-6">
                  <h2 className="text-lg font-semibold text-gray-800 mb-4">
                    Progress to Next Badge
                  </h2>
                  <div className="mb-2">
                    <div className="flex justify-between text-sm text-gray-600 mb-1">
                      <span>{achievementData.current_badge}</span>
                      <span>{achievementData.next_badge}</span>
                    </div>
                    <div className="w-full bg-gray-200 rounded-full h-2.5">
                      <div
                        className="bg-green-600 h-2.5 rounded-full transition-all duration-300"
                        style={{
                          width: `${Math.max(10, 100 - achievementData.remaining_to_unlock_next_badge * 10)}%`,
                        }}
                      ></div>
                    </div>
                  </div>
                  <p className="text-sm text-gray-600">
                    {`${achievementData.remaining_to_unlock_next_badge} purchases remaining to unlock ${achievementData.next_badge}`}
                  </p>
                </div>

                {/* Unlocked Achievements */}
                <div className="bg-white rounded-lg shadow p-6 mb-6">
                  <h2 className="text-lg font-semibold text-gray-800 mb-4">
                    Unlocked Badges (
                    {achievementData.unlocked_achievements.length})
                  </h2>
                  {achievementData.unlocked_achievements.length > 0 ? (
                    <div className="space-y-2">
                      {achievementData.unlocked_achievements.map(
                        (achievement, index) => (
                          <div
                            key={index}
                            className="flex items-center p-3 bg-green-50 rounded border border-green-100"
                          >
                            <span className="text-green-600 mr-3">✓</span>
                            <span className="text-gray-800">{achievement}</span>
                          </div>
                        ),
                      )}
                    </div>
                  ) : (
                    <p className="text-gray-500 text-center py-4">
                      No badges unlocked yet.
                    </p>
                  )}
                </div>

                {/* Next Available Achievements */}
                <div className="bg-white rounded-lg shadow p-6">
                  <h2 className="text-lg font-semibold text-gray-800 mb-4">
                    Next Badges to Unlock (
                    {achievementData.next_available_achievements.length})
                  </h2>
                  {achievementData.next_available_achievements.length > 0 ? (
                    <div className="space-y-2">
                      {achievementData.next_available_achievements.map(
                        (achievement, index) => (
                          <div
                            key={index}
                            className="flex items-center p-3 bg-blue-50 rounded border border-blue-100"
                          >
                            <span className="text-blue-600 mr-3">→</span>
                            <span className="text-gray-800">{achievement}</span>
                          </div>
                        ),
                      )}
                    </div>
                  ) : (
                    <p className="text-gray-500 text-center py-4">
                      All achievements unlocked! Great job!
                    </p>
                  )}
                </div>
              </>
            )}

            {/* If no achievements data */}
            {!achievementData && (
              <div className="bg-white rounded-lg shadow p-6">
                <h2 className="text-lg font-semibold text-gray-800 mb-2">
                  Achievements
                </h2>
                <p className="text-gray-600">No achievement data available.</p>
              </div>
            )}
          </div>
        </div>
      )}
    </>
  );
}
