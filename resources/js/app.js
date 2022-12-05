require("./bootstrap");

window.Vue = require("vue").default;

import Vue from "vue";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
import "@mdi/font/css/materialdesignicons.css";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import VueTour from "vue-tour";
require("vue-tour/dist/vue-tour.css");

const options = {
    transition: "Vue-Toastification__bounce",
    maxToasts: 20,
    newestOnTop: true,
};

Vue.use(Toast, options);

Vue.use(Vuetify);
Vue.use(VueTour);
Vue.component(
    "login-auth-component",
    require("./components/auth/LoginComponent.vue").default
);
Vue.component(
    "register-auth-component",
    require("./components/auth/RegisterComponent.vue").default
);
Vue.component(
    "contacto-component",
    require("./components/content/ContactoComponent.vue").default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
    vuetify: new Vuetify({
        iconfont: "mdi",
        theme: {
            themes: {
                light: {
                    primary: "#1E88E5",
                    secondary: "#363636",
                    accent: "#e3ecf5",
                    error: "#FF5252",
                    info: "#1963ad",
                    success: "#4CAF50",
                    warning: "#FFC107",
                },
            },
        },
    }),

    data: {
        v_crsf: document.querySelector('meta[name="csrf-token"]').content,
        loadOverlay: false,
        links: ["Dashboard", "Messages", "Profile", "Updates"],
        optToast: {
            position: "top-right",
            timeout: 1500,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.6,
            showCloseButtonOnHover: false,
            hideProgressBar: true,
            closeButton: "button",
            icon: true,
            rtl: false,
        },
    },
    beforeMount() {
        this.loadOverlay = true;
    },
    watch: {
        loadOverlay() {
            if (this.loadOverlay) {
                setTimeout(() => {
                    this.loadOverlay = false;
                }, 500);
            }
        },
    },
});
