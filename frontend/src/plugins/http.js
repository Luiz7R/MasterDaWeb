import Vue from "vue";
import axios from "axios";
import store from "@/store";

const token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDEvYXBpL2xvZ2luIiwiaWF0IjoxNjg3MjEwOTQ3LCJleHAiOjE2ODcyMTQ1NDcsIm5iZiI6MTY4NzIxMDk0NywianRpIjoiV3pSeXJBWUsxQVpjM044cyIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.BTNf1ssh5QZ82OrPTtkZ2yL4kl6g3ZBugQfII3Qaxa0";
const instance = axios.create({
  baseURL: "http://localhost:8000/api/",
  headers: {
    "Content-Type": "application/json",
    "Authorization": `bearer ${token}`,
  },
});

instance.interceptors.request.use((config) => {
  store.dispatch('isLoading', true)
  const token = localStorage.getItem("token");
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

instance.interceptors.response.use(function (response) {
  store.dispatch('isLoading', false)
  return response;
}, function (error) {
  store.dispatch('isLoading', false)
  console.error(error)
  return Promise.reject(error);
});

export default {
    install() {
      Vue.prototype.$http = instance;
    },
};
  