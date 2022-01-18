
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import 'tailwindcss/tailwind.css';
import AppLayout from "~/Layout/AppLayout.vue";
import { InertiaProgress } from '@inertiajs/progress';
import Toast  from "vue-toastification";
import "vue-toastification/dist/index.css";



const app = document.getElementById('app');

const pages = import.meta.glob('./Pages/**/*.vue');

createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => {
                const importPage = pages[`./Pages/${name}.vue`];
                if (!importPage) {
                    throw new Error(`Unknown page ${name}. Is it located under Pages with a .vue extension?`);
                }
                return importPage().then(module => {

                    const page = module.default;

                   // console.log(page);

                   if(!page.layout) page.layout = AppLayout;

                    return page;
                })
            }
        }),
})
    .use(InertiaPlugin)
    .use(Toast, {

    })
    .mount(app);


    InertiaProgress.init({

        color: '#FF0000',

        // Whether to include the default NProgress styles.
        includeCSS: true,

        // Whether the NProgress spinner will be shown.
        showSpinner: true,
      })
