import { createApp } from 'vue';
import { createPinia } from 'pinia';

import App from './App.vue';
import router from './router';

import 'bootstrap-icons/font/bootstrap-icons.css';
import "bootstrap/dist/css/bootstrap.min.css"; // to use bootstrap css resources
import "bootstrap"; // to use bootstrap js resources

const app = createApp(App);

app.use(createPinia());
app.use(router);

app.mount('#app');
