import "./bootstrap";
import "../css/app.css";
//
import "jsvectormap/dist/jsvectormap.min.css"
import "flatpickr/dist/flatpickr.min.css"

//

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
const appName = import.meta.env.VITE_APP_NAME || "Laravel";
//
// import RolesPermissionsToVue from "../../vendor/geowrgetudor/laravel-spatie-permissions-vue/src/js";
//
import { createPinia } from 'pinia'
import VueApexCharts from 'vue3-apexcharts'
import { createMemoryHistory, createRouter } from 'vue-router'

// import routes from './routes.js'
// const routes = [
//     { path: '/hello', component: Dashboard },
// ]
// const router = createRouter({
//     history: createMemoryHistory(),
//     routes: routes,
// })
//
import { createNotivue } from 'notivue'
import 'notivue/notification.css' // Only needed if using built-in notifications
import 'notivue/animations.css' // Only needed if using built-in animations
import 'notivue/notification-progress.css'

const notivue = createNotivue({
    position: 'top-right',
    // limit: 5,
    // enqueue: true,
    notifications: {
        global: {
            duration: 3000
        }
    }
})


//

createInertiaApp({
    title: function (title) {
        if (title) {
            return `${title} - ${appName}`;
        } else {
            return `${appName}`;
        }
    },
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = page.default.layout || DefaultLayout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            //
            // .use(RolesPermissionsToVue)
            //
            .use(createPinia())
            .use(VueApexCharts)
            //
            // .use(router)
            //
            .use(notivue, {
                animations: {
                    enter: 'slide-in',
                    leave: 'slide-out',
                    clearAll: 'fade'
                }
            })
            //
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});

