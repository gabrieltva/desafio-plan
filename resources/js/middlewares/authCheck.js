import { userToken, userDashboardRouterName } from "@/utils/user";

const authCheck = async (to, from, next) => {
  try {
    const token = userToken();
    const response = await fetch(import.meta.env.VITE_API_URL_GUARD, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + token
      }
    });

    if (response.ok) {
      next({name: userDashboardRouterName()});
      return;
    }
  } catch (error) {
    next();
    return;
  }
}

export default authCheck;