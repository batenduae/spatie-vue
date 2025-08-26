//main
import "./bootstrap";
import "../css/app.css";
import "../css/primevue.css"
import "../css/primeflags.css"
import 'primeicons/primeicons.css'

//jsvector and flatpickr styles
import "jsvectormap/dist/jsvectormap.min.css"
import "flatpickr/dist/flatpickr.min.css"


////////////////////////////////////////
//main
import {createApp, h} from "vue";
import {createInertiaApp} from "@inertiajs/vue3";
import {ZiggyVue} from "../../vendor/tightenco/ziggy";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";

//pinia
import {createPinia} from 'pinia'

//vueapexcharts
import VueApexCharts from 'vue3-apexcharts'

//vueform
import Vueform from '@vueform/vueform'
import vueformConfig from './../../vueform.config.js'

//notivue
import {createNotivue} from 'notivue'
import 'notivue/notification.css' // Only needed if using built-in notifications
import 'notivue/animations.css' // Only needed if using built-in animations
import 'notivue/notification-progress.css'
//primevue
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import Aura from '@primevue/themes/aura';


//notivue
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


////////////////////////////////////////
const appName = import.meta.env.VITE_APP_NAME || "Laravel";
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
        const pages = import.meta.glob("./Pages/**/*.vue", {eager: true});
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = page.default.layout || DefaultLayout;
        return page;
    },
    setup({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue)
            //
            //
            .use(createPinia())
            //
            .use(VueApexCharts)
            //
            .use(Vueform, vueformConfig)
            //
            .use(notivue, {
                animations: {
                    enter: 'slide-in',
                    leave: 'slide-out',
                    clearAll: 'fade'
                }
            })
            //
            .use(PrimeVue, {
                theme: {
                    preset: Aura,
                    options: {
                        prefix: 'p',
                        darkModeSelector: '.dark',
                        cssLayer: false
                    }
                }
            })
            .use(ToastService)
            //
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
