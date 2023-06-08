export default {
    namespaced: true,

    state: {
        settings: {}
    },
  
    getters: {  
        settings (state) {
            return state.settings
        },
    },
  
    mutations: {
        SET_SETTINGS (state, value) {
            state.settings = value
        }
    },
  
    actions: {    
        async getSettings ({ commit }) {
            let { data } = await axios.get('/api/settings');
            commit('SET_SETTINGS', data);

            return data;
        }
    }
}
  