// import "./bootstrap";
// resources/js/app.js

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap/dist/js/bootstrap.js";

import { createApp } from "vue";
import router from "./router";
import App from "./components/App.vue";

const app = createApp(App);

app.use(router);

app.mount("#app");
