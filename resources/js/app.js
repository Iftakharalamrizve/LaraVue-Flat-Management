
require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router'
Vue.use(VueRouter);
import {routes} from './routes/index';
//import and use vform section 
import {Form,HasError, AlertError , AlertErrors , AlertSuccess} from 'vform';
window.Form=Form;

const router = new VueRouter({
    //mode history use for remove # from url
    mode:'history',
    routes // short for `routes: routes`
  })
window.Vue = require('vue');

//use progreess bar option 
import VueProgressBar from 'vue-progressbar';
const VueProgressBarOptions = {
    color: '#50d38a',
    failedColor: '#87111d',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
};
Vue.use(VueProgressBar,VueProgressBarOptions);

//implement gate 
import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);


/// use notification bar option 
import Snotify, { SnotifyPosition } from 'vue-snotify'

const Snotifyoptions = {
  toast: {
    position: SnotifyPosition.rightTop
  }
}
Vue.use(Snotify, Snotifyoptions)

Vue.component(
  'not-found',
  require('./components/Notfound.vue').default
);
Vue.component(
  'passport-clients',
  require('./components/passport/Clients.vue').default
);

Vue.component(
  'passport-authorized-clients',
  require('./components/passport/AuthorizedClients.vue').default
);


Vue.component(
  'passport-personal-access-tokens',
  require('./components/passport/PersonalAccessTokens.vue').default
);
Vue.component('Pagination', require('./components/Pagination.vue').default);
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component(AlertErrors.name, AlertErrors);
Vue.component(AlertSuccess.name, AlertSuccess);
const app = new Vue({
    el: '#app',
    router,
});
