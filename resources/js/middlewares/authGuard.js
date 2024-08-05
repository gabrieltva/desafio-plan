import { userToken } from "@/utils/user";
import { checkGuard } from "@/services/api";

const authGuard = async (to, from, next) => {
  try {
    const token = userToken();
    if (!token) {
      redirectToLogin();
      return;
    }
    
    checkGuard()
    next()
  } catch (error) {
    redirectToLogin();
  }
}

const redirectToLogin = (next) => {
  next({ name: 'login' });
}

export default authGuard;