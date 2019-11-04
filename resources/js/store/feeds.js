import { userService } from '../services/user';

const state = {
    all: {}
};

const actions = {
    getFeed({ commit }) {
        commit('getAllRequest');

        userService.getFeed()
            .then(
                feed => commit('getAllSuccess', feed),
                error => commit('getAllFailure', error)
            );
    },
};

const mutations = {
    getAllRequest(state) {
        state.all = { loading: true };
    },

    getAllSuccess(state, feed) {
        state.all = feed;
    },

    getAllFailure(state, error) {
        state.all = { error };
    },
};

export const feeds = {
    namespaced: true,
    state,
    actions,
    mutations
};
