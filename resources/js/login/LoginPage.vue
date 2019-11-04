<template>
    <div>
        <h2>Login</h2>
        <form @submit.prevent="handleSubmit">
            <div class="form-group">
                <label for="email">Email</label>

                <input type="text" v-model="email" class="form-control"
                       name="email" id="email"
                       :class="{ 'is-invalid': submitted && !email }" />

                <div v-show="submitted && !email" class="invalid-feedback">
                    Email is required
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" v-model="password" class="form-control"
                       name="password" id="password"
                       :class="{ 'is-invalid': submitted && !password }" />

                <div v-show="submitted && !password" class="invalid-feedback">
                    Password is required
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-primary" :disabled="status.loggingIn">
                    Login
                </button>

                <img v-show="status.loggingIn" src="/images/loading.gif" />

                <router-link to="/register" class="btn btn-link">
                    Register
                </router-link>
            </div>
        </form>
    </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex'

    export default {
        data () {
            return {
                email: '',
                password: '',
                submitted: false
            }
        },
        computed: {
            ...mapState('account', ['status'])
        },
        created () {
            this.logout();
        },
        methods: {
            ...mapActions('account', ['login', 'logout']),

            handleSubmit (e) {
                this.submitted = true;
                const { email, password } = this;
                if (email && password) {
                    this.login({ email, password })
                }
            }
        }
    };
</script>
