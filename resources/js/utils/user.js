const user = () => {
  try {
    const userJson = localStorage.getItem('user');
    const userData = JSON.parse(userJson);

    return userData;
  } catch (error) {
    return {};
  }
}

export default user;

export const userRole = () => {
  const userData = user();
  return userData.role;
}

export const userToken = () => {
  try {
    const token = localStorage.getItem('token');
    return token;
  } catch (error) {
    return '';
  }
}

export const userDashboardRouterName = () => {
  const role = userRole();
  if (role === 'admin') {
    return 'adminDashboard';
  }

  return 'dashboard';
}

export const removeUserData = () => {
  localStorage.removeItem('token');
  localStorage.removeItem('user');
}