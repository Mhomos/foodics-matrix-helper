import Vue from "vue";
import VueRouter from "vue-router";
import axios from "axios";
import Login from "./pages/Login";
import Index from "./Index";
import router from './router';

window.Vue = Vue;
window.axios = axios;
Vue.router = router;


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// require("./bootstrap");

Vue.use(VueRouter);
Vue.component('index', Index);

const app = new Vue({
    el: "#app",
    components: {Login},
    router,
});
