import { userToken } from "@/utils/user";

export const login = async (username, password, role) => {
  const response = await fetch(import.meta.env.VITE_API_URL_LOGIN, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      email: username,
      password: password,
      role: role
    })
  });

  const data = await response.json();

  if (!response.ok) {
    const message = data.message !== undefined ? data.message : 'Erro ao tentar realizar login'
    throw new Error(message)
  }
  
  return data;
}

export const register = async (name, email, password, password_confirmation, role, admin_id = null) => {
  const dataPost = {
    name: name,
    email: email,
    password: password,
    password_confirmation: password_confirmation,
    role: role,
  }

  if (role !== 'admin') {
    dataPost['admin_id'] = admin_id
  }

  const response = await fetch(import.meta.env.VITE_API_URL_REGISTER, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(dataPost)
  });

  const data = await response.json();

  if (!response.ok) {
    const message = data.message !== undefined ? data.message : 'Erro ao tentar realizar o cadastro'
    throw new Error(message)
  }
  
  return data;
}

export const checkIsLogged = async () => {
  const response = await fetch(import.meta.env.VITE_API_URL_GUARD, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + userToken()
    }
  });

  if (!response.ok) {
    throw new Error('Usuário não está logado.')
  }
}

export const checkGuard = async () => {
  const response = await fetch(import.meta.env.VITE_API_URL_GUARD, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + userToken()
    }
  });

  if (!response.ok) {
    throw new Error('Usuário não está logado.')
  }
}

export const studentChangeStatus = async (id, status) => {
  const response = await fetch(import.meta.env.VITE_API_URL_STUDENT_COURSE_STATUS.replace(':id', id), {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + userToken()
    },
    body: JSON.stringify({
      status: status
    })
  });

  if (!response.ok) {
    throw new Error('Erro ao alterar status.')
  }
}

export const adminSaveStudentCourse = async (id, course) => {

}

const getData = async(url) => {
  const response = await fetch(url, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + userToken()
    }
  });

  if (!response.ok) {
    throw new Error('Erro ao recuperar dados.')
  }
  
  const data = await response.json()
  return data
}

export const studentGetCourseList = async () => {
  return await getData(import.meta.env.VITE_API_URL_STUDENT_COURSE_PAGE)
}

export const adminGetCourseList = async () => {
  return await getData(import.meta.env.VITE_API_URL_COURSES)
}

export const adminGetStudentsList = async () => {
  return await getData(import.meta.env.VITE_API_URL_STUDENTS)
}

export const adminGetStudentCourse = async (id) => {
  return await getData(import.meta.env.VITE_API_URL_STUDENT_COURSE.replace(':id', id))
}