
require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

Vue.use(VueRouter);
import store from './store'
import routes from './routes'
import App from './components/App.vue'

 let router=new VueRouter({
 	 routes
 });

 new Vue({
 	store,
	router,
    render:h=>h(App)
    
}).$mount('#app');
