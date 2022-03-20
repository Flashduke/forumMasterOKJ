import axios from 'axios';

export const BASE_URL = 'http://localhost/forumMasterOKJ/php_rest_forum/';

export default axios.create({ baseURL: BASE_URL + 'api' });

export const axiosPrivate = axios.create({
  baseURL: BASE_URL + 'api',
  headers: { 'Content-Type': 'application/json' },
  withCredentials: true,
});
