import axios from 'axios';

const ApiMethod = {
  GET: 'GET',
  POST: 'POST',
  PUT: 'PUT',
  PATCH: 'PATCH',
  DELETE: 'DELETE',
};

const instance = () => {
  const instance = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    timeout: 15000,
  });

  return instance;
};

const request = (method) => (path, options) => {
  // You can add more headers/options here
  // Ex: add Authorization, ....

  const headers = {
    Accept: 'application/json',
  };

  //convert to object.
  options = { ...(options && { ...options }) }
  //add config header.
  options.headers = { ...options.headers, ...headers };

  return instance().request({
    method,
    url: path,
    ...options,
  });
};

export default {
  get: request(ApiMethod.GET),
  post: request(ApiMethod.POST),
  put: request(ApiMethod.PUT),
  patch: request(ApiMethod.PATCH),
  delete: request(ApiMethod.DELETE),
};
