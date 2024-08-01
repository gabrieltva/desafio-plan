import { userToken } from "@/utils/user";

const authGuard = async (to, from, next) => {
  try {
    const token = userToken();
    if (!token) {
      redirectToLogin();
      return;
    }
    
    const response = await fetch(import.meta.env.VITE_API_URL_GUARD, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + token
      }
    });

    if (response.ok) {
      next();
      return;
    }
  } catch (error) {
    redirectToLogin();
  }
}

const redirectToLogin = (next) => {
  next({ name: 'login' });
}

export default authGuard;