/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import "heyui/themes/index.less";

window.Vue = require('vue')
import HeyUI from 'heyui'
import App from './App.vue'
import VueRouter from "vue-router"
import store from './store/index'
import en from 'heyui/dist/locale/en-US'
import VueClip from 'vue-clip'

import { Icon }  from 'leaflet'
import 'leaflet/dist/leaflet.css'

const baseUrl = (process.env.NODE_ENV === 'production') ? 'https://judo-sas.fr' : 'http://localhost' 

// this part resolve an issue where the markers would not appear
delete Icon.Default.prototype._getIconUrl;

Icon.Default.mergeOptions({
  iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
  iconUrl: require('leaflet/dist/images/marker-icon.png'),
  shadowUrl: require('leaflet/dist/images/marker-shadow.png')
});


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
const NewsComponent             = require('./components/NewsComponent.vue').default
const BureauComponent           = require('./components/BureauComponent.vue').default
const BonMomentComponent        = require('./components/BonMomentComponent.vue').default
const AdministrationComponent   = require('./components/AdministrationComponent.vue').default
const ContactComponent          = require('./components/ContactComponent.vue').default
const CotisationComponent       = require('./components/CotisationComponent.vue').default
const HistoriqueComponent       = require('./components/HistoriqueComponent.vue').default
const PlanningComponent         = require('./components/PlanningComponent.vue').default
const ResultatsComponent        = require('./components/ResultatsComponent.vue').default

Vue.use(HeyUI, {locale: en})
Vue.use(VueRouter)
Vue.use(VueClip)

const routes = [
    { path: '/news', component: NewsComponent },
    { path: '/bureau', component: BureauComponent },
    { path: '/bons-moments', component: BonMomentComponent },
    { path: '/contact', component: ContactComponent },
    { path: '/cotisation', component: CotisationComponent },
    { path: '/historique', component: HistoriqueComponent },
    { path: '/planning', component: PlanningComponent },
    { path: '/resultats', component: ResultatsComponent },
    { path: '/administration', component: AdministrationComponent }
]
//Vue.component('example-component', require('./components/ExampleComponent.vue').default);



export const my_axios = axios.create({
    baseURL: baseUrl,
    headers: {
        'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0].getAttribute('content'),
        'Authorization': 'Bearer ' + localStorage.getItem('id_token')
    }
});

my_axios.interceptors.request.use(
    (config) => {
        let token = localStorage.getItem('id_token');

        if (token) {
            config.headers['Authorization'] = `Bearer ${ token }`;
        }

        return config;
    }, 
  
    (error) => {
        return Promise.reject(error);
    }
);

Vue.prototype.$http = my_axios;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
