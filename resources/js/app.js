window.Vue = require('vue').default
import App from './App.vue'
import router from './router'
import store from './store'


store.dispatch('auth/attempt', localStorage.getItem('token'))

Vue.component('home-component',     require('./components/layouts/Home.vue').default);
Vue.component('nav-component',      require('./components/layouts/Nav.vue').default);
Vue.component('search-component',   require('./components/layouts/Search.vue').default);
Vue.component('login-component',    require('./components/auth/Login.vue').default);
Vue.component('register-component', require('./components/auth/Register.vue').default);

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
})