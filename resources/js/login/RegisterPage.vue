<template>
    <div>
        <h2>Register</h2>

        <form @submit.prevent="handleSubmit">
            <div class="form-group">
                <label for="email">Email</label>

                <input type="text" v-model="user.email" class="form-control"
                       name="email" id="email" v-validate="'email'"
                       v-on:keyup="ajaxCheckEmail"
                       :class="{ 'is-invalid': submitted && errors.has('email') }" />

                <div v-if="submitted && errors.has('email')"
                     class="invalid-feedback">{{ errors.first('email') }}</div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input type="password" v-model="user.password" id="password"
                       name="password" class="form-control"
                       v-validate="{ required: true, min: 6 }"
                       :class="{ 'is-invalid': submitted && errors.has('password') }" />

                <div v-if="submitted && errors.has('password')"
                     class="invalid-feedback">{{ errors.first('password') }}</div>
            </div>

            <div class="form-group">
                <button class="btn btn-primary" :disabled="status.registering">
                    Register
                </button>

                <img v-show="status.registering" src="/images/loading.gif" />

                <router-link to="/login" class="btn btn-link">
                    Cancel
                </router-link>
            </div>
        </form>
    </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex'
    import { ValidationObserver } from 'vee-validate';

    export default {
        components: {
            ValidationObserver
        },

        data () {
            return {
                user: {
                    email: '',
                    password: ''
                },
                submitted: false
            }
        },

        computed: {
            ...mapState('account', ['status'])
        },

        methods: {
            ...mapActions('account', ['register', 'checkEmail']),

            handleSubmit(e) {
                if (this.status.emailStatus === 'passed') {
                    this.submitted = true;
                    this.$validator.validate().then(valid => {
                        if (valid) {
                            this.register(this.user);
                        }
                    });
                }
            },

            async ajaxCheckEmail () {
                const isValid = await this.$validator.verify(this.user.email, 'email');

                if (isValid) {
                    this.checkEmail(this.user.email);
                }
            }
        }
    };
</script>
