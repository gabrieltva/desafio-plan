import { userDashboardRouterName } from "@/utils/user";
import { checkIsLogged } from "@/services/api";

const authCheck = async (to, from, next) => {
  try {
    checkIsLogged()
    next({name: userDashboardRouterName()});
  } catch (error) {
    next();
  }
}

export default authCheck;