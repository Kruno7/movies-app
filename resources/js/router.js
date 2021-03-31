import Vue from 'vue'
import Router   from 'vue-router'
import Search   from './components/layouts/Search'
import Login    from './components/auth/Login'
import Register from './components/auth/Register'

Vue.use(Router)

export default new Router({
    mode: 'history',
    routes: [
        { path: '/',         component: Search},
        { path: '/login',    component: Login },
        { path: '/register', component: Register }
    ]
})