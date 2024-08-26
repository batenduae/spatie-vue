import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import GuestLayout from "@/Layouts/GuestLayout.vue";
const appName = import.meta.env.VITE_APP_NAME || "Laravel";

//
import { createNotivue } from 'notivue'
import 'notivue/notification.css' // Only needed if using built-in notifications
import 'notivue/animations.css' // Only needed if using built-in animations
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
        page.default.layout = page.default.layout || GuestLayout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            //
            .use(notivue)


            //
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
