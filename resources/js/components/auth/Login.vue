<template>
    <div class="container">
        <form class="form">
            <h2>Login </h2>
            <div class="form-group">
                <label for="email">Email</label><br>
                <input type="email" v-model="form.email" id="email" autocomplete="off" />
            </div>
            <div class="form-group">
                <label for="passowrd">Password</label><br>
                <input type="password" v-model="form.password" id="password" /><br>
            </div>
            <button type="submit" @click.prevent="login">Login</button>
            <p v-if="errors.length">
            <b>Please correct the following error(s):</b>
            <ul>
                <li v-for="error in errors" :key="error">
                    {{ error }}
                </li>
            </ul>
            </p>
        </form>
    </div>
</template>

<script>

export default {
    name: 'Login',
    data () {
        return {
            form: {
                email   : '',
                password: '',
            },
            errors: [],
        }
    },
    methods: {
        login () {
            if (this.form.email && this.form.password) {
                this.$store.dispatch('auth/loginUser', this.form)
                .then(()=> {})
                .catch(e => {
                    console.log("error")
                })
            }
            this.errors = [];
            if (!this.form.email) {
                this.errors.push('Email required.');
            } else if (!this.validEmail(this.form.email)) {
                this.errors.push('Valid email required.');
            }
            if (!this.form.password) {
                this.errors.push('Password required.');
            }
        },

        validEmail (email) {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
      
    },
}
</script>

<style scoped>
    .container {
        width: 50%;
        min-height: 450px;
        margin: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: aliceblue;
    }
    .form {
        width: 60%;
        border-radius: 15px;
    }
    .form h2 {
        text-align: center;
    }
   
    .form-group {
        text-align:center;
    }

    input[type=email], input[type=password] {
        display: block;
        margin: 0 auto 1em auto;
        width: 70%;
        border: 1px solid #818181;
        padding: 5px;
        border-radius: 5px;
    }

    button {
        width: 70%;
        padding: 7px; 
        margin: 0 auto; 
        display: block;
        background-color: #43ac6a;
        border-radius: 5px;
        border: none;
    }
    button:hover {
        cursor: pointer;
        background-color: #349b5a;
    }
    p {
        text-align:center;
    }
    li {
        list-style: none;
    }
   
</style>