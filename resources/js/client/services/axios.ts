import axios, { AxiosInstance } from "axios";
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const apiClient: AxiosInstance = axios.create({
  headers: {
    "Content-type": "application/json",
  },
});

export default apiClient;
