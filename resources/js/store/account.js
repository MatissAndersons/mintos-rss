import { router } from '../router/router';
import { userService } from '../services/user';

const user = JSON.parse(localStorage.getItem('user'));
const state = user
    ? { status: { loggedIn: true }, user }
    : { status: {}, user: null };

const actions = {
    login({ dispatch, commit }, { email, password }) {
        commit('loginRequest', { email });

        userService.login(email, password)
            .then(
                user => {
                    commit('loginSuccess', user);
                    router.push('/');
                },
                error => {
                    commit('loginFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },

    logout({ commit }) {
        userService.logout();
        commit('logout');
    },

    register({ dispatch, commit }, user) {
        commit('registerRequest', user);

        userService.register(user)
            .then(
                user => {
                    commit('registerSuccess', user);
                    router.push('/login');
                    setTimeout(() => {
                        dispatch('alert/success', 'Registration successful', { root: true });
                    })
                },
                error => {
                    commit('registerFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },

    checkEmail({ dispatch, commit }, email) {
        userService.checkEmail(email)
            .then(
                data => {
                    if (data.exists) {
                        commit('emailCheckFailure', data.message);
                        dispatch('alert/error', data.message, { root: true });
                    } else {
                        commit('emailCheckSuccess', data.message);
                        dispatch('alert/clear', data.message, { root: true });
                    }
                },
                error => {
                    commit('registerFailure', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
};

const mutations = {
    loginRequest(state, user) {
        state.status = { loggingIn: true };
        state.user = user;
    },

    loginSuccess(state, user) {
        state.status = { loggedIn: true };
        state.user = user;
    },

    loginFailure(state) {
        state.status = {};
        state.user = null;
    },

    logout(state) {
        state.status = {};
        state.user = null;
    },

    registerRequest(state, user) {
        state.status = { registering: true };
    },

    registerSuccess(state, user) {
        state.status = {};
    },

    registerFailure(state, error) {
        state.status = {};
    },

    emailCheckSuccess(state, error) {
        state.status = { emailStatus: 'passed' };
    },

    emailCheckFailure(state, error) {
        state.status = { emailStatus: 'failed' };
    },
};

export const account = {
    namespaced: true,
    state,
    actions,
    mutations
};
