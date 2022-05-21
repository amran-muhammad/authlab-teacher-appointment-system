
import {createApp} from 'vue';

require('./bootstrap');


import App from './App.vue';
import axios from 'axios';
import router from './router';
import ViewUIPlus from 'view-ui-plus';
import 'view-ui-plus/dist/styles/viewuiplus.css';
import locale from 'view-ui-plus/dist/locale/en-US';


const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.use(router);
app.use(ViewUIPlus, { locale });
app.mount('#app');