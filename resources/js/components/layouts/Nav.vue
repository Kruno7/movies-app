<template>
    <nav class="navbar">
        <div class="title"><router-link to="/">MOVIE API</router-link></div>
        <a href="#" @click.prevent="toggle" class="toggle-button">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </a>
        <div class="navbar-links" v-bind:class="{ active: isActive }">
            <ul v-if="!user">
                <li>
                    <router-link to="login">Login</router-link>
                </li>
                <li>
                    <router-link to="register">Register</router-link>
                </li>
            </ul>
            <ul v-else>
                <li>
                    <router-link to="/">Home</router-link>
                </li>
                <li>
                    <a href="#" @click.prevent="logout">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>

import { mapGetters } from 'vuex'

export default {
    name: 'Nav',
    data () {
        return {
            isActive: false
        }
    },
    methods: {
        toggle () {
            this.isActive = !this.isActive
        },
        logout () {
            localStorage.removeItem('token')
            this.$store.dispatch('auth/logout')
            this.$router.replace('/login')
        }
    },
    computed: {
        ...mapGetters({
            user: 'auth/user'
        })
    }

}
</script>

<style scoped>


.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: rgb(73, 75, 75);
}

.title {
    padding: 15px;
    
}

.title a {
    text-decoration: none;
    color: #fff;
}

.navbar-links ul {
    margin: 0;
    padding: 0;
    display: flex;
}

.navbar-links li {
    list-style: none;
    padding: 15px;
}

.navbar-links li:hover {
    background-color: rgb(20, 20, 20);
    cursor: pointer;
}

.navbar-links li a {
    text-decoration: none;
    color: rgb(250, 248, 248);
}

.toggle-button {
    position: absolute;
    top: 10px;
    right: 10px;
    display: none;
    flex-direction: column;
    justify-content: space-between;
    width: 30px;
    height: 20px;
}

.toggle-button .bar {
    height: 3px;
    width: 100%;
    background-color: rgb(250, 248, 248);
    border-radius: 10px;
}

@media (max-width: 600px) {
    .toggle-button {
        display: flex;
    }
    .navbar-links {
        display: none;
        width: 100%;
    }

    .navbar {
        flex-direction: column;
        align-items: flex-start;
    }

    .navbar-links ul {
        flex-direction: column;
        width: 100%;
    }
    .navbar-links li {
        text-align: center;
    }

    .navbar-links.active {
        display: flex;
    }
}

</style>