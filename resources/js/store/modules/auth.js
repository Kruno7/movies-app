import axios from 'axios'
import router from '../../router'

export default {
    namespaced: true,
    state: {
        token: null,
        user:  null,
    },

    getters: {
        user (state) {
            return state.user
        }
    },

    mutations: {
        SET_TOKEN (state, token) {
            state.token = token
        },
        SET_USER (state, data) {
            state.user = data
        }
    },

    actions: {
        loginUser ({dispatch}, credentials) {
            axios.post('/api/login', credentials)
            .then(res => {
                localStorage.setItem('token', res.data.token)
                dispatch ('attempt', res.data.token)
                router.replace('/')
            })
        },

        attempt ({ commit, state }, token) {
            if (token) {
                commit('SET_TOKEN', token)
            }

            if (!state.token) {
                return
            }
            
            try {
                axios.get('/api/user', {
                    headers: {
                        'Authorization' : 'Bearer ' + localStorage.getItem('token')
                    }
                })
                .then(res => {
                    commit('SET_USER', res.data)
                })
            } catch (error) {
                commit('SET_TOKEN', null)
                commit('SET_USER',  null)
            }
        },

        logout ({commit}) {
            commit('SET_USER',  null)
            commit('SET_TOKEN', null)
        }
    }

}