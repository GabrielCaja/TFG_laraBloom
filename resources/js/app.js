import './bootstrap';
import { createApp } from 'vue';
import App from "./Components/App.vue";
import ErrorHandler from './errorHandler';
import ErrorNotification from './Components/ErrorNotification.vue';

    const app = createApp(App);
    app.use(ErrorHandler);
    app.component('ErrorNotification', ErrorNotification);
    //Montar app
    app.mount('#dashboard-content')