import axios from "axios";
import router from "../router";

function interceptor(config) {
    const token = localStorage.getItem("token");
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}

// Interceptor to add bearer token if it's exist in localStorage
axios.interceptors.request.use(interceptor, (error) => {
    return Promise.reject(error);
});

// Interceptor to remove token in localStorage if is not valide and redirect user to login page
axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response.status === 401) {
            const url = error.config.url;
            localStorage.removeItem("token");

            if (url.includes("admin")) router.push("/admin/login");
            else router.push("/employee/login");
        }
        return Promise.reject(error);
    }
);

export default axios;
