import { createApp } from "vue";
import app from "./main.vue";
import router from "./router/index";
import { createPinia } from "pinia";
import { i18n } from "./plugins/i18n";
import ElementPlus from "element-plus";
import "../../node_modules/element-plus/theme-chalk/index.css";
import 'remixicon/fonts/remixicon.css';
import de from 'element-plus/dist/locale/de.mjs'

const xapp = createApp(app);
const pinia = createPinia();
xapp.use(ElementPlus,{
    locale: de,
 });
xapp.use(i18n);
xapp.use(pinia);
xapp.use(router);

xapp.mount("#app");
